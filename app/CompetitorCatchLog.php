<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetitorCatchLog extends Model
{
    //
    protected $table = 'ip_competitor_catch_log';

    public function competitor()
    {
        return $this->hasOne("App\Competitor",'id','competitor_id');
    }
}
