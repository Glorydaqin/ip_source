<?php

namespace App\Http\Controllers;

use App\CatchSource;
use App\Competitor;
use App\CompetitorCatch;
use App\CompetitorCatchLog;
use App\Source;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    //根据竞争对手返回可用ip
    public function getIp($competitor)
    {
        $ipinfo = Source::where(['competitor_id' => $competitor, 'status' => 'active'])->orderBy('updated_at', 'asc')->first();
        if ($ipinfo) {
            Source::where(['competitor_id' => $competitor, 'ip' => $ipinfo['ip']])->update(['updated_at' => date("Y-m-d H:i:s")]);
            return $ipinfo['ip'];
        } else {
            //优先取其他竞争对手的可用ip
            $ipinfo = Source::where(['status' => 'active'])->orderBy('updated_at', 'asc')->first();
            if ($ipinfo) {
                //原数据更新时间,防止重复取值
                Source::where("id", $ipinfo['id'])->update(['updated_at' => date("Y-m-d H:i:s")]);
                $find = [
                    'competitor_id' => $competitor,
                    'ip' => $ipinfo['ip'],
                ];
                $data = [
                    'catch_fail' => 5,
                    'status' => 'active'
                ];
                Source::updateOrCreate($find, $data);
                return $ipinfo['ip'];
            } else {

                //实在没有可用ip了
                //取最近入库的，成功数最多的
                $ipinfo = Source::where(['competitor_id' => $competitor])->orderBy("catch_success", 'desc')->first();
                return $ipinfo['ip'] ?? '';
            }
        }
    }

    //
    public function setIp($competitor, $ip, $status)
    {
        // 不以异步异步方式执行记录抓取效果了
//        ProcessSetIp::dispatch($competitor,$ip,$status);
        $ipinfo = Source::where(['ip' => $ip, 'competitor_id' => $competitor])->first();
        if (!$ipinfo || !in_array($status, ['fail', 'success'])) {
            return 1;
        }
        if ($ipinfo['catch_fail'] > 5 && $status == 'fail') {
            //修改为失败
            Source::where(['ip' => $ip, 'competitor_id' => $competitor])->update(['catch_fail' => $ipinfo['catch_fail'] + 1, 'status' => 'delete']);
        } else {
            if ($status == 'success') {
                Source::where(['ip' => $ip, 'competitor_id' => $competitor])->update(['catch_success' => $ipinfo['catch_success'] + 1]);
            } else {
                Source::where(['ip' => $ip, 'competitor_id' => $competitor])->update(['catch_fail' => $ipinfo['catch_fail'] + 1]);
            }
        }
        CompetitorCatchLog::insert(['competitor_id' => $competitor, 'ip' => $ip, 'status' => $status]);
        return 1;
    }

    public function getPanel(Request $request)
    {
        $type = $request->get("type", 1);

        if ($type == 1) {

            $all_competitor = Competitor::where("status", 'active')->get();
            foreach ($all_competitor as &$compeitor) {
                $compeitor->active_ip_num = Source::where("competitor_id", $compeitor->id)->where("status", "active")->count();
            }

            //补全最近两天抓取效果
            $todayCatch = CompetitorCatch::where("catch_date", date('Y-m-d'))->get();
            $yestodayCatch = CompetitorCatch::where("catch_date", date("Y-m-d", strtotime("-1 day")))->get();
            foreach ($all_competitor as &$competitor) {
                $competitor->yestoday_catch_success =
                $competitor->yestoday_catch_fail =
                $competitor->today_catch_success =
                $competitor->today_catch_fail = 0;

                foreach ($todayCatch as $catch) {
                    if ($competitor->id == $catch->competitor_id) {
                        $competitor->today_catch_success = $catch->catch_success;
                        $competitor->today_catch_fail = $catch->catch_fail;
                    }
                }
                foreach ($yestodayCatch as $catch) {
                    if ($competitor->id == $catch->competitor_id) {
                        $competitor->yestoday_catch_success = $catch->catch_success;
                        $competitor->yestoday_catch_fail = $catch->catch_fail;
                    }
                }
            }

            return $all_competitor ?? [];
        } else {

            //最新ip抓取结果
            $catch_log = CompetitorCatchLog::orderBy('id', 'desc')->limit(10)->get();
            foreach ($catch_log as &$log) {
                $log->name = $log->competitor->name ?? '';
            }
            return $catch_log ?? [];
        }
    }
}
