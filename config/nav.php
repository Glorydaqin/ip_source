<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/4
 * Time: 10:39
 */

return [

    '验证网站管理'=>
    [
        'icon'=>'fa-desktop',
        'link'=>'#',

        'level'=>
        [
            '创建验证网站'=>'Admin\CompetitorController@insert',
            '验证列表'=>'Admin\CompetitorController@store',
        ]
    ],
    'ip来源管理'=>[
        'icon'=>'fa-bar-chart-o',
        'link'=>'#',

        'level'=>[
            '创建ip来源'=>'Admin\CatchSourceController@insert',
            'ip来源列表'=>'Admin\CatchSourceController@store'
        ]
    ],
    '监控提醒'=>[
        'icon'=>'fa-edit',
        'link'=>'#',

        'level'=>
        [
            '进程调度'=>'/horizon/dashboard',
        ]
    ],

];