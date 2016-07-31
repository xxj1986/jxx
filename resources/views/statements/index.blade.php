@extends('app')
        <?php $menuCtl = ['statements','dayStatements'] ?>
@section('mainContents')
        <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">单日流水记录</h3>
                    <form id="searchForm" method="GET" class="form-inline pull-right">
                        日期
                        <input type="text" name="mobile" value="{{$params['date'] or ''}}" onchange="startSearch();" class="form-control" placeholder="手机号">
                        模式
                        <select name="mode" class="form-control" onchange="startSearch();">
                            <option value="view" @if(isset($params['mode']) && $params['mode'] == 'view') selected @endif>浏览模式</option>
                            <option value="record" @if(isset($params['mode']) && $params['mode'] == 'record') selected @endif>录入模式</option>
                        </select>
                    </form>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>序号</th>
                            <th>技师</th>
                            <th>金额</th>
                            <th>项目名称</th>
                            <th>额外消费</th>
                            <th>上钟时间</th>
                            <th>备注</th>
                            <th><a href="javascript:addStatement();">录入</a></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($statements as $one)
                        <tr>
                            <td>{{$one->id}}</td>
                            <td>{{$one->tech_num}}</td>
                            <td>{{$one->price}}</td>
                            <td>{{$one->proj_name}}</td>
                            <td>{{$one->extra}}</td>
                            <td>{{$one->service_time}}</td>
                            <td>{{$one->remark}}</td>
                            <td>
                                <a href="/admin/statements/{{$one->id}}">更改</a>
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
                <h4 class="modal-title">新开会员卡</h4>
            </div>
            <form method="POST" class="form-horizontal">
                {!! csrf_field() !!}
            <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="input1" class="col-sm-3 control-label">手机号</label>

                            <div class="col-sm-7">
                                <input type="text" name="mobile" class="form-control" id="input1" placeholder="请输入手机号">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input2" class="col-sm-3 control-label">充值金额</label>

                            <div class="col-sm-7">
                                <input type="text" name="money" class="form-control" id="input2" placeholder="请输入金额">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input3" class="col-sm-3 control-label">卡号</label>

                            <div class="col-sm-7">
                                <input type="text" name="card_num" class="form-control" id="input3" placeholder="请刷卡">
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
<div id="chargeModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">会员充值</h4>
            </div>
            <form id="chargeForm" method="POST" class="form-horizontal">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="type" value="2">
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="input1" class="col-sm-3 control-label">手机号</label>

                            <div class="col-sm-7">
                                <input type="text" name="mobile" class="form-control" id="mobile" readonly placeholder="请输入手机号">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input2" class="col-sm-3 control-label">充值金额</label>

                            <div class="col-sm-7">
                                <input type="text" name="money" class="form-control" id="input2" placeholder="请输入金额">
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
<script src="{{url('/lte/dist/js/app.min.js')}}"></script>
<script>
    $(function(){
        var tr = '';
        $('.chargeBtn').click(function(){
            tr = $(this).closest('tr');
            $('#chargeForm').attr('action','/admin/members/' + (tr.children().eq(0).text()).trim() );
            $('#mobile').val( (tr.children().eq(1).text()).trim() );
            $('#chargeModal').modal();
        });
    });
    function addStatement(){$('#addModal').modal()}
    function startSearch(){$('#searchForm').submit()}
</script>
@endsection