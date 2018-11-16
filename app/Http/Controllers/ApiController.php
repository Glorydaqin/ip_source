<?php

namespace App\Http\Controllers;

use App\CompetitorCatchLog;
use App\Jobs\ProcessSetIp;
use App\Source;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    //根据竞争对手返回可用ip
    public function getIp($competitor)
    {
        $ipinfo = Source::where(['competitor_id'=>$competitor,'status'=>'active'])->orderBy('updated_at','asc')->first();
        if($ipinfo){
            Source::where(['competitor_id'=>$competitor,'ip'=>$ipinfo['ip']])->update(['updated_at'=>date("Y-m-d H:i:s")]);
            return $ipinfo['ip'];
        }else{
            //优先取其他竞争对手的可用ip
            $ipinfo = Source::where(['status'=>'active'])->orderBy('updated_at','asc')->first();
            if($ipinfo){
                //原数据更新时间,防止重复取值
                Source::where("id",$ipinfo['id'])->update(['updated_at'=>date("Y-m-d H:i:s")]);
                $find = [
                    'competitor_id'=>$competitor,
                    'ip'=>$ipinfo['ip'],
                ];
                $data = [
                    'catch_fail'=>5,
                    'status'=>'active'
                ];
                Source::updateOrCreate($find,$data);
                return $ipinfo['ip'];
            }else{

                //实在没有可用ip了
                //取最近入库的，成功数最多的
                $ipinfo = Source::where(['competitor_id'=>$competitor])->orderBy("catch_success",'desc')->first();
                return $ipinfo['ip']??'';
            }
        }
    }

    //
    public function setIp($competitor,$ip,$status)
    {
        ProcessSetIp::dispatch($competitor,$ip,$status);
        return 1;
    }
}
