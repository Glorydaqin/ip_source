<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competitor extends Model
{
    //
    protected $table="ip_competitor";

    /**
     * 为数组 / JSON 序列化准备日期。
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format($this->dateFormat ?: 'Y-m-d H:i:s');
    }

}
