@extends('app')
        <?php $menuCtl = ['statements','dayStatements'] ?>
@section('mainContents')
        <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">技师流水统计</h3>
                    <form id="searchForm" method="GET" class="form-inline pull-right">
                        日期
                        <input type="text" name="date" size="9" value="{{$params['date'] or ''}}" onchange="startSearch();" class="form-control" placeholder="手机号">
                        模式
                        <select name="mode" class="form-control" onchange="startSearch();">
                            <option value="view" @if(isset($params['mode']) && $params['mode'] == 'view') selected @endif>浏览模式</option>
                            <option value="record" @if(isset($params['mode']) && $params['mode'] == 'record') selected @endif>录入模式</option>
                        </select>
                    </form>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="statementsTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>序号</th>
                            <th>技师</th>
                            <th>手机号</th>
                            <th>上钟次数</th>
                            <th>总金额</th>
                            <th>备注</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($techs as $one)
                        <tr>
                            <td>{{$one->id}}</td>
                            <td>{{$one->tech_num}}</td>
                            <td>{{$one->mobile}}</td>
                            @if(isset($statements[$one->tech_num]))
                                <td>{{$statements[$one->tech_num]->total_num}}</td>
                                <td>{{$statements[$one->tech_num]->total_sales}}</td>
                            @else
                                <td></td><td></td>
                            @endif
                            <td>{{$one->remark or ''}}</td>
                            <td>
                                <a href="#" class="copyBtn">详情</a>
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

@endsection

@section('pageJs')
<script src="{{url('/lte/dist/js/app.min.js')}}"></script>
<script>
    function startSearch(){$('#searchForm').submit()}
</script>
@endsection