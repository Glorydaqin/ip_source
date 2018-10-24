<?php

namespace App\Http\Controllers\Admin;

use App\CatchSource;
use App\Competitor;
use App\CompetitorCatch;
use App\CompetitorCatchLog;
use App\Source;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    //index
    public function index()
    {
        //验证网站
        $all_competitor_num = Competitor::count();
        $all_active_competitor_num = Competitor::where("status",'active')->count();
        //ip来源
        $all_catch_source_num = CatchSource::count();
        $all_active_catch_source_num = CatchSource::where("status",'active')->count();
        //总数
        $all_ip_num = Source::distinct('ip')->count('ip');
        $all_active_ip_num = Source::where('status','active')->distinct('ip')->count();

        $all_competitor = Competitor::where("status",'active')->get();
        foreach ($all_competitor as &$compeitor){

            $compeitor->active_ip_num = Source::where("competitor_id",$compeitor->id)->where("status","active")->count();

        }
        $all_catch_source = CatchSource::where("status",'active')->get();

        //最新ip抓取结果
        $catch_log = CompetitorCatchLog::orderBy('id','desc')->limit(10)->get();
        //补全最近两天抓取效果
        $todayCatch = CompetitorCatch::where("catch_date",date('Y-m-d'))->get();
        $yestodayCatch = CompetitorCatch::where("catch_date",date("Y-m-d",strtotime("-1 day")))->get();
        foreach ($all_competitor as &$competitor){
            $competitor->yestoday_catch_success =
            $competitor->yestoday_catch_fail =
            $competitor->today_catch_success =
            $competitor->today_catch_fail = 0;

            foreach ($todayCatch as $catch){
                if($competitor->id == $catch->competitor_id){
                    $competitor->today_catch_success = $catch->catch_success;
                    $competitor->today_catch_fail = $catch->catch_fail;
                }
            }
            foreach ($yestodayCatch as $catch){
                if($competitor->id == $catch->competitor_id){
                    $competitor->yestoday_catch_success = $catch->catch_success;
                    $competitor->yestoday_catch_fail = $catch->catch_fail;
                }
            }
        }
//        dd($all_competitor);
        return view("admin.home",compact('all_ip_num','all_active_ip_num','all_competitor_num','all_active_competitor_num','all_catch_source_num','all_active_catch_source_num','all_competitor','all_catch_source','catch_log'));
    }

}
