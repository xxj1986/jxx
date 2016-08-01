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
                <h4 class="modal-title">上钟记录录入</h4>
            </div>
            <form method="POST" class="form-horizontal">
                {!! csrf_field() !!}
            <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="tech_num" class="col-sm-2 control-label">技师</label>
                            <div class="col-sm-8">
                                <select name="tech_num" id="tech_num"  class="form-control">
                                    <option value="0">请选择</option>
                                    @foreach($techs as $v)
                                        <option value="{{$v}}">{{$v}}号</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price" class="col-sm-2 control-label">金额</label>
                            <div class="col-sm-8">
                                <input type="text" name="price" class="form-control" id="price" placeholder="请输入消费金额">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="proj_select" class="col-sm-2 control-label">项目</label>
                            <div class="col-sm-5">
                                <input type="text" name="proj_name" class="form-control" id="proj_name" placeholder="请输入项目">
                            </div>
                            <div class="col-sm-3">
                                <select id="proj_select"  class="form-control">
                                    <option value="0">请选择</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="extra" class="col-sm-2 control-label">额外消费</label>
                            <div class="col-sm-8">
                                <input type="text" name="extra" class="form-control" id="extra" placeholder="烟酒消费金额，没有则不填">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="proj_select" class="col-sm-2 control-label">上钟时间</label>
                            <div class="col-sm-4">
                                <select name="hour" class="form-control">
                                    <option value="10">10点</option>
                                    <option value="11">11点</option>
                                    <option value="12">12点</option>
                                    <option value="13">13点</option>
                                    <option value="14">14点</option>
                                    <option value="15">15点</option>
                                    <option value="16">16点</option>
                                    <option value="17">17点</option>
                                    <option value="18">18点</option>
                                    <option value="19">19点</option>
                                    <option value="20">20点</option>
                                    <option value="21">21点</option>
                                    <option value="22">22点</option>
                                    <option value="23">23点</option>
                                    <option value="24">24点</option>
                                    <option value="01">01点</option>
                                    <option value="02">02点</option>
                                    <option value="03">03点</option>
                                    <option value="04">04点</option>
                                    <option value="05">05点</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <select name="minute" class="form-control">
                                    <option value="00">00分</option><option value="05">05分</option>
                                    <option value="10">10分</option><option value="15">15分</option>
                                    <option value="20">20分</option><option value="25">25分</option>
                                    <option value="30">30分</option><option value="35">35分</option>
                                    <option value="40">40分</option><option value="45">45分</option>
                                    <option value="50">50分</option><option value="55">55分</option>
                                </select>
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