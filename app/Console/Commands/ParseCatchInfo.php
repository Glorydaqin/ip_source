<?php

namespace App\Console\Commands;

use App\Competitor;
use App\CompetitorCatchLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ParseCatchInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:parse_catch_info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '分析竞争对手当天抓取成功失败次数';

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

        //分批删除15天前抓取记录
        DB::table("competitor_catch_log")->where("created_at",'<',date("Y-m-d H:i:s",strtotime('-15 days')))
            ->orderBy("id",'asc')
            ->chunk(2000,function ($logs){
                CompetitorCatchLog::whereIn("id",$logs->pluck('id'))->delete();
                dump("del 2000");
            });

        $yestoday = date("Y-m-d",strtotime("-1 day"));
        $today = date("Y-m-d");
        $dates = [$yestoday,$today];

        //获取所有有效竞争对手
        $competitor = Competitor::where("status",'active')->get();

        foreach ($dates as $date){

            //获取日志表竞争对手成功数
            $competitorCatchSuccess = CompetitorCatchLog::where("status",'success')->whereRaw("DATE_FORMAT(created_at,'%Y-%m-%d') = '{$date}'")->groupBy("competitor_id")->select(DB::raw("competitor_id,count(competitor_id) as catch_num"))->get();
            //获取日志表竞争对手失败数
            $competitorCatchFail = CompetitorCatchLog::where("status",'fail')->whereRaw("DATE_FORMAT(created_at,'%Y-%m-%d') = '{$date}'")->groupBy("competitor_id")->select(DB::raw("competitor_id,count(competitor_id) as catch_num"))->get();
            $competitor_arr = array();
            foreach ($competitor as $item) {
                $competitor_arr[$item->id] = array("catch_success"=>0,"catch_fail"=>0);
                foreach ($competitorCatchSuccess as $catchSuccess){
                    if($catchSuccess->competitor_id == $item->id){
                        $competitor_arr[$item->id]['catch_success'] = $catchSuccess->catch_num;
                    }
                }
                foreach ($competitorCatchFail as $catchFail){
                    if($catchFail->competitor_id == $item->id){
                        $competitor_arr[$item->id]['catch_fail'] = $catchFail->catch_num;
                    }
                }
            }
            //入库
            $replace_insert_sql = "insert into ip_competitor_catch(`competitor_id`,`catch_success`,`catch_fail`,`catch_date`) values ";

            $insert_arr = array();
            foreach ($competitor_arr as $competitor_id=>$arr){
                $insert_arr[] = "({$competitor_id},'{$arr['catch_success']}','{$arr['catch_fail']}','{$today}')";
            }
            if(!empty($insert_arr)){
                $replace_insert_sql = $replace_insert_sql.implode(",",$insert_arr)." ON DUPLICATE KEY update `catch_success` = values(`catch_success`),`catch_fail` = values(`catch_fail`),`updated_at`=now()";
                DB::select($replace_insert_sql);
            }
        }

        //分批删除15天前抓取记录
        CompetitorCatchLog::where("created_at",'<',date("Y-m-d H:i:s",strtotime('-15 days')))->chunck(2000,function ($logs){
            dd($logs->pluck('id'));
            CompetitorCatchLog::whereIn("id",$logs->pluck('id'))->delete();
        });
    }
}
