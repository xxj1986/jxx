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
                            <div class="col-sm-4">
                                <input type="text" name="mobile" class="form-control" placeholder="请输入手机号">
                            </div>
                            <div class="col-sm-3">
                                <a href="javascript:;" class="btn btn-block btn-success checkBtn">检测</a>
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
                    <button type="submit" class="btn btn-primary">保存</button>
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
                            <div class="col-sm-4">
                                <input type="text" name="mobile" class="form-control" placeholder="请输入手机号">
                            </div>
                            <div class="col-sm-3">
                                <a href="javascript:;" class="btn btn-block btn-success checkBtn">检测</a>
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

@section('extJs')
    <script>
        $(function(){
            $('.checkBtn').click(function(){
                console.log(11);
                var form = $(this).closest('form');
                form.attr('action','/');
                var mobile = form.find("input[name='mobile']").val();
                $.get('/admin/members/checkMember/'+mobile,
                        function(res){
                            if(res.errCode == 0){
                                var data = res.data;
                                form.attr('action','/admin/members/'+data.id);
                                var str = '<span style="color: green;">' +
                                        '账户存在,余额<strong style="color: orangered">' +
                                        data.balance +'</strong>元</span>';
                            }else{
                                var str = '<span style="color: orangered;">' +
                                        '账户不存在或已经冻结</span>';
                            }
                            form.find('div.memberResDiv').html(str);
                        }
                )
            })
        });
        function directCharge(){$('#directChargeModal').modal()}
        function directConsume(){$('#directConsumeModal').modal()}
    </script>
@endsection