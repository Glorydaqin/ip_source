<?php

namespace App\Jobs;

use App\CompetitorCatchLog;
use App\Source;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessSetIp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $competitor;
    private $ip;
    private $status;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($competitor,$ip,$status)
    {
        $this->competitor = $competitor;
        $this->ip = $ip;
        $this->status = $status;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ipinfo = Source::where(['ip'=>$this->ip,'competitor_id'=>$this->competitor])->first();
        if($ipinfo['catch_fail']>5 and $this->status=='fail'){
            //修改为失败
            Source::where(['ip'=>$this->ip,'competitor_id'=>$this->competitor])->update(['catch_fail'=>$ipinfo['catch_fail']+1,'status'=>'delete']);
            CompetitorCatchLog::insert(['competitor_id'=>$this->competitor,'ip'=>$this->ip,'status'=>"fail"]);
        }else{
            if($this->status == 'success'){
                Source::where(['ip'=>$this->ip,'competitor_id'=>$this->competitor])->update(['catch_success'=>$ipinfo['catch_success']+1]);
                CompetitorCatchLog::insert(['competitor_id'=>$this->competitor,'ip'=>$this->ip,'status'=>"success"]);
            }else{
                Source::where(['ip'=>$this->ip,'competitor_id'=>$this->competitor])->update(['catch_fail'=>$ipinfo['catch_fail']+1]);
                CompetitorCatchLog::insert(['competitor_id'=>$this->competitor,'ip'=>$this->ip,'status'=>"fail"]);
            }
        }
    }
}
