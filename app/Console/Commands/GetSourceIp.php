<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\CatchSource;
use App\Competitor;

class GetSourceIp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:get_source_ip';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '获取数据源ip';

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
        $insert_arr = array();
        //获取需要验证的网站
        $competitor = Competitor::where("status", 'active')->get();
        //获取有效的ip资源
        $catch_source = CatchSource::where("status", 'active')->get();
        //遍历所有资源
        foreach ($catch_source as $item) {

            try {
                $options  = array('verify' => false); //不验证ssl
                $request = \Requests::get($item['url'],[],$options);
                $str = $request->body;
                if ($str) {
                    $match_res = preg_match_all($item['match_preg'], $str, $match_ips);
                    if ($match_res) {

                        //遍历资源
                        foreach ($match_ips[1] as $key => $match_ip) {
                            $match_ip = (isset($match_ips[2][$key]) && stripos($match_ip, ':') === false) ?
                                $match_ip . ':' . $match_ips[2][$key] :
                                $match_ip;
                            //遍历需要验证网站
                            foreach ($competitor as $com) {

                                $insert_arr[] = array("competitor_id" => $com->id, "ip" => trim($match_ip));
                            }
                        }
                        //更新获取数量
                        CatchSource::where("id", $item->id)->update(
                            ['last_match_num' => count($match_ips[1]), 'last_error_info' => null,
                                'updated_at' => date("Y-m-d H:i:s")]);

                    } else {
                        new \Exception('没有匹配到数据');
                    }

                }
            } catch (\Exception $exception) {
                CatchSource::where("id", $item->id)->update(
                    ['last_match_num' => 0, 'last_error_info' => substr($exception->getMessage(), 0, 500),
                        'updated_at' => date("Y-m-d H:i:s")]);
            }

        }

        //数据入库
        $insert_tmp = array();
        foreach ($insert_arr as $item) {
            $insert_tmp[] = "({$item['competitor_id']},'{$item['ip']}')";
            if (count($insert_tmp) > 1000) {
                DB::insert("insert ignore ip_source(`competitor_id`,`ip`) values " . implode(',', $insert_tmp));
                $insert_tmp = array();
            }
        }
        if (!empty($insert_tmp)) {
            DB::insert("insert ignore ip_source(`competitor_id`,`ip`) values " . implode(',', $insert_tmp));
        }
    }
}
