<?php

namespace App\Http\Controllers;

use App\CompetitorCatchLog;
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
        // 不以异步异步方式执行记录抓取效果了
//        ProcessSetIp::dispatch($competitor,$ip,$status);
        $ipinfo = Source::where(['ip'=>$ip,'competitor_id'=>$competitor])->first();
        if($ipinfo['catch_fail']>5 and $status=='fail'){
            //修改为失败
            Source::where(['ip'=>$ip,'competitor_id'=>$competitor])->update(['catch_fail'=>$ipinfo['catch_fail']+1,'status'=>'delete']);
            CompetitorCatchLog::insert(['competitor_id'=>$competitor,'ip'=>$ip,'status'=>"fail"]);
        }else{
            if($status == 'success'){
                Source::where(['ip'=>$ip,'competitor_id'=>$competitor])->update(['catch_success'=>$ipinfo['catch_success']+1]);
                CompetitorCatchLog::insert(['competitor_id'=>$competitor,'ip'=>$ip,'status'=>"success"]);
            }else{
                Source::where(['ip'=>$ip,'competitor_id'=>$competitor])->update(['catch_fail'=>$ipinfo['catch_fail']+1]);
                CompetitorCatchLog::insert(['competitor_id'=>$competitor,'ip'=>$ip,'status'=>"fail"]);
            }
        }
        return 1;
    }
}
