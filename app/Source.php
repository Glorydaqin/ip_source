<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    //
    protected $table="ip_source";

    protected $fillable = [ 'catch_fail','status','competitor_id','ip' ];
}
