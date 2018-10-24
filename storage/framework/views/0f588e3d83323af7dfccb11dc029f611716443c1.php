<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>H+ 后台主题UI框架 - 基本表单</title>


    <link rel="shortcut icon" href="<?php echo e(asset("favicon.ico")); ?>">
    <link href="<?php echo e(asset("admin/css/bootstrap.min.css")); ?>?v=3.3.5" rel="stylesheet">
    <link href="<?php echo e(asset("admin/css/font-awesome.min.css")); ?>?v=4.4.0" rel="stylesheet">
    <link href="<?php echo e(asset("admin/css/plugins/iCheck/custom.css")); ?>" rel="stylesheet">
    <link href="<?php echo e(asset("admin/css/animate.min.css")); ?>" rel="stylesheet">
    <link href="<?php echo e(asset("admin/css/style.min.css")); ?>?v=4.0.0" rel="stylesheet">
    <?php echo $__env->yieldContent("style"); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

</head>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <?php $__env->startSection('title'); ?>
                    <h5>修改<small>验证网站</small></h5>
                    <?php echo $__env->yieldSection(); ?>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <?php $__env->startSection("form"); ?>
                <div class="ibox-content">
                    <form method="post" class="form-horizontal">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="id" value="<?php echo e($competitor->id); ?>">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">网站别名</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" value="<?php echo e($competitor->name); ?>">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">链接</label>
                            <div class="col-sm-10">
                                <input type="text" name="url" class="form-control" value="<?php echo e($competitor->url); ?>">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">验证字符串</label>
                            <div class="col-sm-10">
                                <input type="text" name="flag" class="form-control" value="<?php echo e($competitor->flag); ?>"><span class="help-block m-b-none">用于检测获取到的页面是否是正确数据</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">最少ip数</label>
                            <div class="col-sm-10">
                                <input type="text" name="min_num" class="form-control" value="<?php echo e($competitor->min_num); ?>"><span class="help-block m-b-none">用于控制ip库保证有足够多有效ip可用</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">status</label>
                            <div class="col-sm-10">
                                active<input type="radio" name="status" value="active" <?php if($competitor->status == 'active'): ?> checked="checked" <?php endif; ?>>&nbsp;&nbsp;
                                delete<input type="radio" name="status" value="delete" <?php if($competitor->status == 'delete'): ?> checked="checked" <?php endif; ?>>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" name="submit" type="submit">保存内容</button>
                                <button class="btn btn-white" type="submit">取消</button>
                            </div>
                        </div>
                    </form>
                </div>
                <?php echo $__env->yieldSection(); ?>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo e(asset("admin/js/jquery.min.js")); ?>?v=2.1.4"></script>
<script src="<?php echo e(asset('admin/js/bootstrap.min.js')); ?>?v=3.3.5"></script>
<script src="<?php echo e(asset('admin/js/plugins/peity/jquery.peity.min.js')); ?>"></script>
<script src="<?php echo e(asset('admin/js/content.min.js')); ?>?v=1.0.0"></script>
<script src="<?php echo e(asset('admin/js/plugins/iCheck/icheck.min.js')); ?>"></script>
<script>
    $(document).ready(function(){$(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",})});
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<?php echo $__env->yieldContent("script"); ?>
</body>

</html>