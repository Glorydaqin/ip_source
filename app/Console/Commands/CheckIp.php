<?php

namespace App\Console\Commands;

use App\CatchSource;
use App\Competitor;
use App\Source;
use Ares333\Curl\Curl;
use Illuminate\Console\Command;
use Illuminate\Foundation\PackageManifest;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Psy\Exception\ErrorException;

class CheckIp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:check_ip';
    protected $max_size = 100;
    protected $sleep_time = 10; //异步请求发送间隔 微秒
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '检查数据库中ip';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "\nstart at ".date("Y-m-d H:i:s");
        //获取需要验证的网站
        $competitors = Competitor::where("status",'active')->get();

        //准备数据
        $check_ips = array();
        foreach ($competitors as $competitor) {
            $limit = $competitor->min_num * 5;
            $all_check_ips = Source::whereRaw('(status="normal" or status="active") and competitor_id=' . $competitor->id)->limit($limit)->get();

            $active_ips = $normal_ips = array();
            foreach ($all_check_ips as $item) {
                if ($item['status'] == 'active') {
                    $active_ips[] = array('url'=>$competitor->url, 'competitor_id'=>$item->competitor_id,'ip'=> $item->ip,'flag'=>$competitor->flag );
                } else {
                    $normal_ips[] = array('url'=>$competitor->url, 'competitor_id'=>$item->competitor_id,'ip'=> $item->ip,'flag'=>$competitor->flag );
                }
            }

            if (count($active_ips) > ($competitor->min_num * 2)) {
                //现存有效ip大于需要有效ip *2
                foreach ($active_ips as $ip){
                    $check_ips[] = $ip;
                }
            } elseif(count($normal_ips) > 0) {
                //正常ip>0
                foreach ($normal_ips as $ip){
                    $check_ips[] = $ip;
                }
            }else{
                //没有ip了。取失效ip
                $delete_ips = Source::where(['status'=>'delete','competitor_id'=>$competitor->id])->orderBy("updated_at",'asc')->limit($limit)->get();
                foreach ($delete_ips as $delete_ip){
                    $check_ips[] = array('url'=>$competitor->url, 'competitor_id'=>$delete_ip->competitor_id,'ip'=> $delete_ip->ip,'flag'=>$competitor->flag );
                }
            }
            //更新竞争对手检查时间
            Competitor::where("id",$competitor->id)->update(['updated_at'=>date("Y-m-d H:i:s")]);
        }

        //初始化添加任务
        $results = array();
        $active_no = $delete_no = 0;

        $curl = new Curl();
        foreach ($check_ips as $ip){
            // https://www.google.com/search?q=curl&start=10
            $apt = $this->getOpt($ip['url'],$ip['ip']);
            $curl->add(array(
                'opt' => $apt,
                'args' => array('competitor_id'=>$ip['competitor_id'],'ip'=>$ip['ip'],'flag'=>$ip['flag'])
            ), function($r,$args) use (&$results,&$active_no,&$delete_no){

                $content = $r['body'];
                if(stripos($content,$args['flag'])){
                    $results[] = array(
                        'competitor_id'=>$args['competitor_id'],
                        'ip'=>$args['ip'],
                        'status'=>'active'
                    );
                    $active_no++;
                }else{
                    $results[] = array(
                        'competitor_id'=>$args['competitor_id'],
                        'ip'=>$args['ip'],
                        'status'=>'delete'
                    );
                    $delete_no++;
                }
            },function($r,$args) use (&$results,&$active_no,&$delete_no){
                //false
//                var_dump($args);
                $results[] = array(
                    'competitor_id'=>$args['competitor_id'],
                    'ip'=>$args['ip'],
                    'status'=>'delete'
                );
                $delete_no++;
            });
        }
        $curl->maxThread = 200;
        $curl->start();


        echo "\nactive no-{$active_no},delete_no-{$delete_no}";
        echo "\nstart write--".date("Y-m-d H:i:s");
        //入库
        $up_ip_sql = $up_ip_pre_sql = "insert into ip_source(`competitor_id`,`ip`,`status`) values ";
        $updated_at =date("Y-m-d H:i:s");

        foreach ($results as $result){
            $up_ip = addslashes($result['ip']);
            $up_ip_sql.="({$result['competitor_id']},'{$up_ip}','{$result['status']}'),";
        }
        if($up_ip_sql!=$up_ip_pre_sql){
            $up_ip_sql = substr($up_ip_sql,0,(strlen($up_ip_sql)-1))." ON DUPLICATE KEY update `status` = values(`status`),`updated_at`='{$updated_at}'";
            DB::select($up_ip_sql);
        }
        echo "\nend at ".date("Y-m-d H:i:s");
    }


    public function getOpt($url,$ipinfo=''){
        $url_arr=parse_url($url);
        $source_url="http://".$url_arr['host'];

        $options = array();
        $agentArray=array(
            "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:37.0) Gecko/20100101 Firefox/37.0",
            "Mozilla/5.0 (Windows NT 6.1; rv:12.0) Gecko/20100101 Firefox/12.0",
            "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.11 TaoBrowser/2.0 Safari/536.11",
            "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.71 Safari/537.1 LBBROWSER",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E; LBBROWSER)",
            "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; QQDownload 732; .NET4.0C; .NET4.0E; LBBROWSER)",
            "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.84 Safari/535.11 LBBROWSER",
            "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E; QQBrowser/7.0.3698.400)",
            "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; QQDownload 732; .NET4.0C; .NET4.0E)",
            "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Trident/4.0; SV1; QQDownload 732; .NET4.0C; .NET4.0E; 360SE)",
            "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; QQDownload 732; .NET4.0C; .NET4.0E)",
            "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)",
            "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.89 Safari/537.1",
            "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.89 Safari/537.1",
            "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; QQDownload 732; .NET4.0C; .NET4.0E)",
            "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)",
            "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.84 Safari/535.11 SE 2.X MetaSr 1.0",
            "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Trident/4.0; SV1; QQDownload 732; .NET4.0C; .NET4.0E; SE 2.X MetaSr 1.0)",
            "Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:16.0) Gecko/20121026 Firefox/16.0"
        );
        $ind=rand(0, count($agentArray)-1);
        $options[CURLOPT_URL]=$url;
        $options[CURLOPT_USERAGENT]=$agentArray[$ind];
        $options[CURLOPT_REFERER]=$source_url;
        $options[CURLOPT_TIMEOUT]=30;
        $options[CURLOPT_FOLLOWLOCATION]=1;
        $options[CURLOPT_RETURNTRANSFER]=1;
        $options[CURLOPT_SSL_VERIFYPEER]=0;
        $options[CURLOPT_SSL_VERIFYHOST]=0;
        if(!empty($ipinfo)){
            $options[CURLOPT_PROXY]=$ipinfo;
        }

        return $options;
    }
}
