<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>H+ 后台主题UI框架 - 首页示例二</title>
    <meta name="keywords" content="H+后台主题,后台bootstrap框架,会员中心主题,后台HTML,响应式后台">
    <meta name="description" content="H+是一个完全响应式，基于Bootstrap3最新版本开发的扁平化主题，她采用了主流的左右两栏式布局，使用了Html5+CSS3等现代技术">

    <link rel="shortcut icon" href="favicon.ico"> <link href="css/bootstrap.min.css?v=3.3.5" rel="stylesheet">
    <link href="css/font-awesome.min.css?v=4.4.0" rel="stylesheet">

    <!-- Morris -->
    <link href="css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/style.min.css?v=4.0.0" rel="stylesheet">

</head>

<body class="gray-bg">
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right">验证网站</span>
                    <h5>网站总数</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php echo e($all_competitor_num); ?></h1>
                    <div class="stat-percent font-bold text-success"><?php echo e($all_active_competitor_num); ?> <i class="fa fa-bolt"></i>
                    </div>
                    <small>有效数</small>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right">ip来源</span>
                    <h5>来源总数</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php echo e($all_catch_source_num); ?></h1>
                    <div class="stat-percent font-bold text-success"><?php echo e($all_active_catch_source_num); ?> <i class="fa fa-bolt"></i>
                    </div>
                    <small>有效数</small>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right">有效ip</span>
                    <h5>ip总数</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php echo e($all_ip_num); ?></h1>
                    <div class="stat-percent font-bold text-success"><?php echo e($all_active_ip_num); ?> <i class="fa fa-bolt"></i>
                    </div>
                    <small>验证有效ip</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-sm-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>ip验证清单</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table table-hover no-margins">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>name</th>
                            <th>限制ip最少</th>
                            <th>有效ip数</th>
                            <th>昨日效果</th>
                            <th>今日效果</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $all_competitor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $competitor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                               <?php echo e($competitor->id); ?>

                            </td>
                            <td>
                                <a href="<?php echo e($competitor->url); ?>" target="_blank" title="<?php echo e($competitor->url); ?>"><span style="color:hotpink;"><?php echo e($competitor->name); ?></span></a>
                            </td>
                            <td>
                                <?php echo e($competitor->min_num); ?>

                            </td>
                            <td class="text-navy">
                                <?php echo e($competitor->active_ip_num); ?>

                            </td>
                            <td>
                                <?php echo e($competitor->yestoday_catch_success); ?>/
                                <?php echo e($competitor->yestoday_catch_fail); ?>

                                (<?php echo e(getPercent($competitor->yestoday_catch_success,$competitor->yestoday_catch_success +$competitor->yestoday_catch_fail)); ?>)
                            </td>
                            <td class="text-navy">
                                <?php echo e($competitor->today_catch_success); ?>/
                                <?php echo e($competitor->today_catch_fail); ?>

                                (<?php echo e(getPercent($competitor->today_catch_success,$competitor->today_catch_success +$competitor->today_catch_fail)); ?>)
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>ip来源</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table table-hover no-margins">
                        <thead>
                        <tr>
                            <th>url</th>
                            <th>匹配规则</th>
                            <th>最近获取ip数</th>
                            <th>updated_at</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $all_catch_source; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <span style="color:hotpink;"><?php echo e($source->url); ?></span>
                                </td>
                                <td><?php echo e($source->match_preg); ?></td>
                                <td>
                                    <?php echo e($source->last_match_num); ?>

                                </td>
                                <td class="text-navy">
                                    <?php echo e($source->updated_at); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <table class="table table-hover no-margins">
                        <thead>
                        <tr>
                            <th colspan="4">实时效果</th>
                        </tr>
                        <tr>
                            <th>网站</th>
                            <th>ip</th>
                            <th>状态</th>
                            <th>时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $catch_log; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><span style="color:hotpink;"><?php echo e($item->competitor->name); ?></span></td>
                            <td><?php echo e($item->ip); ?></td>
                            <td><?php echo e($item->status); ?></td>
                            <td class="text-navy"><?php echo e($item->created_at); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="js/jquery.min.js?v=2.1.4"></script>
<script src="js/bootstrap.min.js?v=3.3.5"></script>
<script src="js/plugins/flot/jquery.flot.js"></script>
<script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="js/content.min.js?v=1.0.0"></script>
<script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="js/plugins/gritter/jquery.gritter.min.js"></script>

    
            
                
                        
                            
                                
                        
                        
            
    


</body>

</html>