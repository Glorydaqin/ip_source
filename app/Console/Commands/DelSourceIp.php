<?php

namespace App\Console\Commands;

use App\Source;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
class DelSourceIp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:del_source_ip';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '删除部分过期ip';

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

        //删除一天前添加的 并且 失效 的 ip
        echo "\nstarted at--".date("Y-m-d H:i:s");
        $day_before = date("Y-m-d",strtotime('-1 day'));
        Source::where('status','delete')->where('created_at','<',$day_before)->delete();
        echo "\nended at--".date("Y-m-d H:i:s");
    }
}
