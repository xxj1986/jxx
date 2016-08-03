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
                            <th>编号</th>
                            <th>手机号</th>
                            <th>角色</th>
                            <th>编号</th>
                            <th>最后登录</th>
                            <th>注册</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $one)
                        <tr>
                            <td>{{$one->id}}</td>
                            <td>{{$one->mobile}}</td>
                            <td>{{$one->role}}</td>
                            <td>{{$one->tech_num}}</td>
                            <td>{{$one->created_at}}</td>
                            <td>{{$one->created_at}}</td>
                            <td>
                                <a href="#" class="editBtn">编辑</a>
                            </td>
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
<div id="editModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">用户信息编辑</h4>
            </div>
            <form id="postForm" method="POST" class="form-horizontal">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="input1" class="col-sm-3 control-label">技师号</label>

                            <div class="col-sm-7">
                                <input type="text" name="tech_num" class="form-control" id="input1" placeholder="请输入技师号">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input2" class="col-sm-3 control-label">角色</label>

                            <div class="col-sm-7">
                                <input type="text" name="role" class="form-control" id="input2" placeholder="请输入角色">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
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
<script>$(function () {$("#example1").DataTable()});
    $("#example1").on('click','.editBtn',function(){
        tr = $(this).closest('tr');
        $('#postForm').attr('action','/admin/users/'+(tr.children().eq(0).text()).trim() );
        $('#input1').val((tr.children().eq(3).text()).trim());
        $('#input2').val((tr.children().eq(2).text()).trim());
        $('#editModal').modal();
    });
</script>
@endsection