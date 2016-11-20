@extends('auth.auth')

@section('mainContents')
    <div class="register-box">
        <div class="register-logo">
            <a href="#"><b>温雅阁</b>管理系统</a>
        </div>

        <div class="register-box-body">
            <p class="login-box-msg">注册一个新帐号</p>

            <form method="post">
                {!! csrf_field() !!}
                <div class="form-group has-feedback">
                    <input type="text" name="mobile" value="{{old('mobile')}}" class="form-control" placeholder="手机号">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password" class="form-control" placeholder="密码">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="重复密码">
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">注册</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <a href="{{url('/auth/login')}}" class="text-center">我已经有帐号</a>
        </div>
        <!-- /.form-box -->
    </div>
@endsection