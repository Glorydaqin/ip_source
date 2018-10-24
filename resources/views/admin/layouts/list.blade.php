<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>H+ 后台主题UI框架 - 数据表格</title>

    <link rel="shortcut icon" href="{{ asset("favicon.ico") }}">
    <link href="{{ asset("admin/css/bootstrap.min.css") }}?v=3.3.5" rel="stylesheet">
    <link href="{{ asset("admin/css/font-awesome.min.css") }}?v=4.4.0" rel="stylesheet">
    <link href="{{ asset("admin/css/plugins/iCheck/custom.css") }}" rel="stylesheet">
    <link href="{{ asset("admin/css/animate.min.css") }}" rel="stylesheet">
    <link href="{{ asset("admin/css/style.min.css") }}?v=4.0.0" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    @section('title')
                    <h5>基本 <small>分类，查找</small></h5>
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
                <div class="ibox-content">
                    @if(session("status"))
                    <div class="alert alert-success alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        {{ session("status") }}
                    </div>
                    @endif
                    @section("search")
                    <div class="row">
                        <div class="col-sm-5 m-b-xs">
                            <select class="input-sm form-control input-s-sm inline">
                                <option value="0">请选择</option>
                                <option value="1">选项1</option>
                                <option value="2">选项2</option>
                                <option value="3">选项3</option>
                            </select>
                        </div>
                        <div class="col-sm-4 m-b-xs">
                            <div data-toggle="buttons" class="btn-group">
                                <label class="btn btn-sm btn-white">
                                    <input type="radio" id="option1" name="options">天</label>
                                <label class="btn btn-sm btn-white active">
                                    <input type="radio" id="option2" name="options">周</label>
                                <label class="btn btn-sm btn-white">
                                    <input type="radio" id="option3" name="options">月</label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input type="text" placeholder="请输入关键词" class="input-sm form-control"> <span class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-primary"> 搜索</button> </span><span class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-danger"> 删除</button> </span>
                            </div>
                        </div>
                    </div>
                    @show

                    <div class="table-responsive">
                        @section("list")
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>

                                <th></th>
                                <th>项目</th>
                                <th>进度</th>
                                <th>任务</th>
                                <th>日期</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <input type="checkbox" checked class="i-checks" name="input[]">
                                </td>
                                <td>米莫说｜MiMO Show</td>
                                <td><span class="pie">0.52/1.561</span>
                                </td>
                                <td>20%</td>
                                <td>2014.11.11</td>
                                <td><a href="table_basic.html#"><i class="fa fa-check text-navy"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" class="i-checks" name="input[]">
                                </td>
                                <td>商家与购物用户的交互试衣应用</td>
                                <td><span class="pie">6,9</span>
                                </td>
                                <td>40%</td>
                                <td>2014.11.11</td>
                                <td><a href="table_basic.html#"><i class="fa fa-check text-navy"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" class="i-checks" name="input[]">
                                </td>
                                <td>天狼---智能硬件项目</td>
                                <td><span class="pie">3,1</span>
                                </td>
                                <td>75%</td>
                                <td>2014.11.11</td>
                                <td><a href="table_basic.html#"><i class="fa fa-check text-navy"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" class="i-checks" name="input[]">
                                </td>
                                <td>线下超市+线上商城+物流配送互联系统</td>
                                <td><span class="pie">4,9</span>
                                </td>
                                <td>18%</td>
                                <td>2014.11.11</td>
                                <td><a href="table_basic.html#"><i class="fa fa-check text-navy"></i></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        @show
                    </div>
                    <div class="page">
                        @yield('page')
                    </div>
                </div>
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