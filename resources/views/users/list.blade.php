@extends('app')
        <?php $menuCtl = ['userAndRole','userList'] ?>
@section('mainContents')
        <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">用户列表</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>用户名</th>
                            <th>手机号</th>
                            <th>角色</th>
                            <th>编号</th>
                            <th>最后登录</th>
                            <th>注册</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $one)
                        <tr>
                            <td>{{$one->name}}</td>
                            <td>{{$one->mobile or ''}}</td>
                            <td>{{$one->role}}</td>
                            <td>{{$one->tec_num or ''}}</td>
                            <td>{{$one->created_at}}</td>
                            <td>{{$one->created_at}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
@endsection

@section('pageJs')
        <!-- DataTables -->
<script src="{{url('/lte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{url('/lte/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{url('/lte/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{url('/lte/plugins/fastclick/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('/lte/dist/js/app.min.js')}}"></script>
<!-- page script -->
<script>$(function () {$("#example1").DataTable()});</script>
@endsection