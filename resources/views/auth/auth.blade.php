<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>温雅阁</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{url('/lte/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('/lte/awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{url('/lte/fonts/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{url('/lte/dist/css/AdminLTE.min.css')}}">
    @yield('pageCss')
</head>
<body class="hold-transition login-page">
@yield('mainContents')
<script src="{{url('/lte/plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
<script src="{{url('/lte/bootstrap/js/bootstrap.min.js')}}"></script>
@yield('pageJs')
</body>
</html>
