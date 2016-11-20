@extends('auth.auth')

@section('pageCss')
    <link rel="stylesheet" href="{{url('/lte/plugins/iCheck/square/blue.css')}}">
@endsection
@section('mainContents')
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>温雅阁</b>管理系统</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">请登录后开始使用</p>
        <div class="bg-warning">
            @if(Session::has('message'))
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-warning"></i>用户名或密码错误!</h4>
                </div>
                {{Session::get('message')}}
            @endif
        </div>
        <form action="{{url('/auth/login')}}" method="post">
            {!! csrf_field() !!}
            <div class="form-group has-feedback">
                <input type="text" class="form-control" name="mobile" value="{{old('mobile')}}" placeholder="手机号">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" name="password" placeholder="密码">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox"> 下次自动登录
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <a href="{{url('/auth/register')}}" class="text-center">注册</a>

    </div>
    <!-- /.login-box-body -->
</div>
@endsection

@section('pageJs')
<script src="{{url('/lte/plugins/iCheck/icheck.min.js')}}"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
@endsection