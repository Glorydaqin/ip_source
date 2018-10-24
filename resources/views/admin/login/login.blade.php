<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <title>真心赚后台 - 登录</title>
    <meta name="keywords">
    <meta name="content">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/style.min.css" rel="stylesheet">
    <link href="css/login.min.css" rel="stylesheet">
    <!--[if lt IE 8]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <script>
        if(window.top!==window.self){window.top.location=window.location};
    </script>

</head>

<body class="signin">
<div class="signinpanel">
    <div class="row">
        <div class="col-sm-7">
            <div class="signin-info">
                <div class="logopanel m-b">
                    <h1>[ Hi ]</h1>
                </div>
                <div class="m-b"></div>
                <h4>欢迎使用 <strong>真心赚后台</strong></h4>
                <ul class="m-b">
                    <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 牛逼</li>
                    <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 给力</li>
                    <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 强悍</li>
                    <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 高效</li>
                    <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 无敌</li>
                </ul>
                {{--<strong>还没有账号？ <a href="#">立即注册&raquo;</a></strong>--}}
            </div>
        </div>
        <div class="col-sm-5">
            <form method="post" action="{{ Url("admin/login") }}">
                {{ csrf_field() }}
                <h4 class="no-margins">登录：</h4>
                <p class="m-t-md">登录到真心赚后台</p>
                <input type="text" class="form-control uname" name="user_name" placeholder="用户名" />
                <input type="password" class="form-control pword " name="user_pass" placeholder="密码" />

                @if (count($errors) > 0)
                    <div class="alert alert-info">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {{--<a href="">忘记密码了？</a>--}}
                <button class="btn btn-success btn-block" onclick="this.submit()">登录</button>
            </form>
        </div>
    </div>
    <div class="signup-footer">
        <div class="pull-left">
            &copy; 2017 All Rights Reserved. Zxzuan
        </div>
    </div>
</div>
</body>

</html>