@extends('app')
<?php $menuCtl = ['statements','projList'] ?>
@section('mainContents')
        <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">项目列表</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>项目ID</th>
                            <th>项目名称</th>
                            <th>单价(元)</th>
                            <th>时长(分)</th>
                            <th>备注</th>
                            <th><a href="javascript:addProject();">添加</a></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($projects as $one)
                            <tr>
                                <td>{{$one->id}}</td>
                                <td>{{$one->proj_name}}</td>
                                <td>{{$one->price}}</td>
                                <td>{{$one->time_spec}}</td>
                                <td>{{$one->remark}}</td>
                                <td>
                                    <a href="#" class="editBtn">编辑</a>
                                    <a href="#" class="delBtn">删除</a>
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
<div id="addModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">新增/编辑项目</h4>
            </div>
            <form id="postForm" method="POST" class="form-horizontal">
                {!! csrf_field() !!}
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="proj_name" class="col-sm-3 control-label">项目名称</label>

                            <div class="col-sm-7">
                                <input type="text" name="proj_name" class="form-control" id="proj_name" placeholder="请输入项目名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price" class="col-sm-3 control-label">单价</label>

                            <div class="col-sm-7">
                                <input type="text" name="price" class="form-control" id="price" placeholder="请输入单价金额">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="time_spec" class="col-sm-3 control-label">时长</label>

                            <div class="col-sm-7">
                                <input type="text" name="time_spec" class="form-control" id="time_spec" placeholder="请输入项目消耗时间">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="remark" class="col-sm-3 control-label">项目内容</label>

                            <div class="col-sm-7">
                                <input type="text" name="remark" class="form-control" id="remark" placeholder="项目描述，选填">
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
<script src="{{url('/lte/dist/js/demo.js')}}"></script>
<!-- page script -->
<script>
    $(function () {
        var tr = '';
        $("#example1").DataTable();
        $("#example1").on('click','.editBtn',function(){
            tr = $(this).closest('tr');
            $('#postForm').attr('action','/admin/projects/'+(tr.children().eq(0).text()).trim() );
            $("#postForm [name='_method']").remove();
            $('#postForm').append('<input type="hidden" name="_method" value="PUT">');
            $('#proj_name').val((tr.children().eq(1).text()).trim());
            $('#price').val((tr.children().eq(2).text()).trim());
            $('#time_spec').val((tr.children().eq(3).text()).trim());
            $('#remark').val((tr.children().eq(4).text()).trim());
            $('#addModal').modal();
        });
        $("#example1").on('click','.delBtn',function(){
            tr = $(this).closest('tr');
            layer.confirm('您确定要删除这个项目吗？',function(){
                $('#postForm').attr('action','/admin/projects/'+(tr.children().eq(0).text()).trim() );
                $("#postForm [name='_method']").remove();
                $('#postForm').append('<input type="hidden" name="_method" value="DELETE">');
                $('#postForm').submit();
            });
        });
    });
    function addProject(){
        $('#postForm').attr('action','/admin/projects');
        $("#postForm [name='_method']").remove();
        $('#addModal').modal();
    }
</script>
@endsection