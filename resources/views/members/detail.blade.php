@extends('app')
        <?php $menuCtl = ['memberManage','memberList'] ?>
@section('mainContents')
        <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">会员【{{$oneInfo->mobile}}】账户详情</h3>
                    <form method="GET" class="form-inline pull-right">
                        时间范围
                        <input type="text" name="startTime" size="11" value="{{$params['startTime'] or ''}}" class="form-control" placeholder="起始日期">
                        至
                        <input type="text" name="endTime" size="11" value="{{$params['endTime'] or ''}}" class="form-control" placeholder="结束日期">
                        状态
                        <select name="type" class="form-control">
                            <option value="">不限</option>
                            <option value="1" @if(isset($params['type']) && $params['type'] == '1') selected @endif>消费</option>
                            <option value="2" @if(isset($params['type']) && $params['type'] == '2') selected @endif>充值</option>
                        </select>
                        <button type="submit" class="btn btn-primary">搜索</button>
                    </form>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>单号</th>
                            <th>账户余额</th>
                            <th>充值金额</th>
                            <th>消费金额</th>
                            <th>内容</th>
                            <th>发生时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($history as $one)
                        <tr>
                            <td>{{$one->id}}</td>
                            <td>{{$one->balance}}</td>
                            <td>{{$one->recharged}}</td>
                            <td>{{$one->consumed}}</td>
                            <td>{{$one->remark}}</td>
                            <td>{{$one->created_at}}</td>
                        </tr>
                        @endforeach
                    </table>
                    {!! $history->appends($params)->render() !!}
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
@endsection