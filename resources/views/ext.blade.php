<div id="directChargeModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">会员充值</h4>
            </div>
            <form method="POST" action="/admin/members" class="form-horizontal">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="type" value="2">
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="input1" class="col-sm-3 control-label">手机号</label>
                            <div class="col-sm-7">
                                <input type="text" name="mobile" class="form-control" onblur="checkMember(this);" placeholder="请输入手机号">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-7 memberResDiv"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">充值金额</label>

                            <div class="col-sm-7">
                                <input type="text" name="money" class="form-control" placeholder="请输入金额">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">充值</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div id="directConsumeModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">会员消费</h4>
            </div>
            <form method="POST" class="form-horizontal">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="type" value="1">
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">手机号</label>
                            <div class="col-sm-7">
                                <input type="text" name="mobile" class="form-control" onblur="checkMember(this);" placeholder="请输入手机号">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-7 memberResDiv"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">技师号</label>
                            <div class="col-sm-7">
                                <input type="text" name="tech_num" class="form-control" placeholder="请输入技师机号">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">消费金额</label>

                            <div class="col-sm-7">
                                <input type="text" name="money" class="form-control" placeholder="请输入金额">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">消费项目</label>

                            <div class="col-sm-7">
                                <input type="text" name="remark" class="form-control" placeholder="消费项目">
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
<div id="frozeModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">会员挂失</h4>
            </div>
            <form method="POST" action="/admin/members" class="form-inline">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="DELETE">

                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            请输入 手机号
                            <input type="text" name="mobile" size="15" class="form-control" onblur="checkMember(this);" placeholder="请输入手机号">
                            或卡号
                            <input type="text" name="mobile" size="15" class="form-control" onblur="checkMember(this);" placeholder="请刷卡">
                            挂失
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-7 memberResDiv"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">挂失</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@section('extJs')
    <script>
        function directCharge(){$('#directChargeModal').modal()}
        function directConsume(){$('#directConsumeModal').modal()}
        function frozeMember(){$('#frozeModal').modal()}
        function skipEnter(){if(event.keyCode==13) event.returnValue = false}
        function checkMember(e){
            var form = $(e).closest('form');
            form.attr('action','/');
            var mobile = form.find("input[name='mobile']").val();
            console.log(mobile);
            $.get('/admin/members/checkMember/'+mobile,
                    function(res){
                        var msg = '';
                        if(res.errCode == 0){
                            var data = res.data;
                            form.attr('action','/admin/members/'+data.id);
                            msg = '<span style="color: green;">' +
                                    '账户余额<strong style="color: orangered">' +
                                    data.balance +'</strong>元</span>';
                        }else{
                            msg = '<span style="color: orangered;">' + res.errMsg + '</span>';
                        }
                        form.find('div.memberResDiv').html(msg);
                    }
            )
        }
    </script>
@endsection