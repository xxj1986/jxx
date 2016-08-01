@extends('app')
        <?php $menuCtl = ['userAndRole','roleList'] ?>
@section('mainContents')
        <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">角色列表</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>角色ID</th>
                            <th>角色名称</th>
                            <th>权限</th>
                            <th>备注</th>
                            <th><a href="javascript:addRole();">新增</a></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $one)
                        <tr>
                            <td>{{$one->id}}</td>
                            <td>{{$one->name}}</td>
                            <td>{{$one->prev_str}}</td>
                            <td>{{$one->remark}}</td>
                            <td>
                                <a href="#">编辑</a>
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
                <h4 class="modal-title">新增角色</h4>
            </div>
            <form method="POST" class="form-horizontal">
                {!! csrf_field() !!}
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="input1" class="col-sm-3 control-label">角色名称</label>

                            <div class="col-sm-7">
                                <input type="text" name="name" class="form-control" id="input1" placeholder="请输入角色名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input2" class="col-sm-3 control-label">角色描述</label>

                            <div class="col-sm-7">
                                <input type="text" name="remark" class="form-control" id="input2" placeholder="角色简单描述，选填">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">取消</button>
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
<script src="{{url('/lte/dist/js/app.min.js')}}"></script>
<script>function addRole(){$('#addModal').modal()}</script>
@endsection