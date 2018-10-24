<?php
/**
 * Created by PhpStorm.
 * User: daqin
 * Date: 2017/10/29
 * Time: 19:30
 */
//返回百分比
function getPercent($one_num,$two_num){
    if($one_num==0 || $two_num==0){
        $r=0;
    }else{
        $r = round($one_num/$two_num,3);
        $r = ($r*100);
    }
    return $r."%";
}