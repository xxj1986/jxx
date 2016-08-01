@extends('app')
        <?php $menuCtl = ['memberManage','records'] ?>

@section('mainContents')
        <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">会员卡消费记录</h3>
                    <form method="GET" class="form-inline pull-right">
                        日期
                        <input type="text" name="date" value="{{$params['date'] or ''}}" class="form-control" placeholder="日期">
                        类型
                        <select name="type" class="form-control">
                            <option value="">不限</option>
                            <option value="1" @if(isset($params['type']) && $params['type'] == '1') selected @endif>消费</option>
                            <option value="2" @if(isset($params['type']) && $params['type'] == '2') selected @endif>充值</option>
                        </select>
                        <button type="submit" class="btn btn-warning">搜索</button>
                    </form>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>单号</th>
                            <th>手机号</th>
                            <th>账户余额</th>
                            <th>充值金额</th>
                            <th>消费金额</th>
                            <th>内容</th>
                            <th>发生时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($records as $one)
                            <tr>
                                <td>{{$one->id}}</td>
                                <td>{{$one->mobile}}</td>
                                <td>{{$one->balance}}</td>
                                <td>{{$one->recharged}}</td>
                                <td>{{$one->consumed}}</td>
                                <td>{{$one->remark}}</td>
                                <td>{{$one->created_at}}</td>
                            </tr>
                        @endforeach
                    </table>
                    {!! $records->appends($params)->render() !!}
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
    function addMember(){$('#addModal').modal()}
</script>
@endsection