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
                    <h5>列表 <small>所有ip抓取资源</small></h5>
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
                        <form method="get">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input type="text" placeholder="请输入关键词" name="url" class="input-sm form-control" value="{{ isset( $_GET['url'] )?$_GET['url']:'' }}"> <span class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-primary"> 搜索</button> </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @show

                    <div class="table-responsive">
                        @section("list")
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>desc</th>
                                <th>url</th>
                                <th>match_preg</th>
                                <th>status</th>
                                <th>created_at</th>
                                <th>updated_at</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $item)
                            <tr>
                                <td>
                                    {{ $item->id }}
                                </td>
                                <td><span class="text-success">{{ $item->description }}</span></td>
                                <td>{{ $item->url }}</td>
                                <td>{{$item->match_preg}}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->updated_at }}</td>
                                <td>
                                    <a href="{{ action("Admin\CatchSourceController@update",['id'=>$item->id]) }}">修改</a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @show
                    </div>
                    <div class="page">
                        {{--@yield('page')--}}
                        {{ $list->links() }}
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