<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>H+ 后台主题UI框架 - 基本表单</title>


    <link rel="shortcut icon" href="{{ asset("favicon.ico") }}">
    <link href="{{ asset("admin/css/bootstrap.min.css") }}?v=3.3.5" rel="stylesheet">
    <link href="{{ asset("admin/css/font-awesome.min.css") }}?v=4.4.0" rel="stylesheet">
    <link href="{{ asset("admin/css/plugins/iCheck/custom.css") }}" rel="stylesheet">
    <link href="{{ asset("admin/css/animate.min.css") }}" rel="stylesheet">
    <link href="{{ asset("admin/css/style.min.css") }}?v=4.0.0" rel="stylesheet">
    @yield("style")
    <meta name="csrf-token" content="{{ csrf_token() }}" />

</head>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    @section('title')
                    <h5>创建<small>新的ip数据源</small></h5>
                    @show
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                @section("form")
                <div class="ibox-content">
                    <form method="post" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-sm-2 control-label">链接</label>
                            <div class="col-sm-10">
                                <input type="text" name="url" class="form-control">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">描述</label>
                            <div class="col-sm-10">
                                <input type="text" name="description" class="form-control">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">正则匹配规则</label>
                            <div class="col-sm-10">
                                <input type="text" name="match_preg" class="form-control"><span class="help-block m-b-none">用户匹配ip数据</span>
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
                @show
            </div>
        </div>
    </div>
</div>

<script src="{{ asset("admin/js/jquery.min.js") }}?v=2.1.4"></script>
<script src="{{ asset('admin/js/bootstrap.min.js') }}?v=3.3.5"></script>
<script src="{{ asset('admin/js/plugins/peity/jquery.peity.min.js') }}"></script>
<script src="{{ asset('admin/js/content.min.js') }}?v=1.0.0"></script>
<script src="{{ asset('admin/js/plugins/iCheck/icheck.min.js') }}"></script>
<script>
    $(document).ready(function(){$(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",})});
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@yield("script")
</body>

</html>