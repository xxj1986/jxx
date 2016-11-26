<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MembersController extends Controller
{
    /**
     * 会员卡
     */
    public function index(Request $request)
    {
        $params = $request->input();
        $query = DB::table('members');
        if(isset($params['mobile']) && !empty($params['mobile'])){
            $query = $query->where('mobile','like','%'.$params['mobile'].'%');
        }
        if(isset($params['cardID']) && !empty($params['cardID'])){
            $query = $query->where('card_id','like','%'.$params['cardID']);
        }
        if(isset($params['frozen']) && $params['frozen'] != ''){
            $query = $query->where('frozen',intval($params['frozen']));
        }
        $members = $query->orderBy('id','DESC')->paginate();
        return view('members.list',compact('params','members'));
    }

    /**
     * 没有使用
     */
    public function create()
    {
        //
    }

    /**
     * 新开会员卡
     */
    public function store(Request $request)
    {
        $mobile = trim($request->get('mobile'));
        if(!$mobile){
            return back()->with('message','请填写正确手机号');
        }
        $real_total = floatval($request->get('real_money'));
        $balance = $recharged_total = floatval($request->get('money'));
        $card_num = trim($request->get('card_num'));
        $card_id = trim($request->get('card_id'));
        $created_at = date('Y-m-d H:i:s');
        $data = compact('real_total','mobile','balance','recharged_total','card_num','card_id','created_at');
        $res = DB::table('members')->insert($data);
        if($res){ // 记录账户余额变动
            $record = compact('mobile','balance');
            $record['recharged'] = $balance;
            $record['real_money'] = $real_total;
            $record['remark'] = '新开会员充值';
            $record['created_at'] = date('Y-m-d H:i:s');
            DB::table('cash_records')->insert($record);
        }
        $msg = $res ? '添加成功' : '添加失败';
        return back()->with('message',$msg);
    }

    /**
     * 会员账户详情
     */
    public function show(Request $request, $id)
    {
        if(!intval($id)) return false;
        //获取账户详情
        $oneInfo = DB::table('members')->where('id',$id)->first();
        $query = DB::table('cash_records')->where('mobile',$oneInfo->mobile);
        $startTime = $request->get('startTime');
        $endTime = $request->get('endTime');
        $type = $request->get('type');
        $params = compact('startTime','endTime','type');
        if($startTime){
            $query = $query->where('created_at','>=',$startTime);
        }
        if($endTime){
            $query = $query->where('created_at','<',date('Y-m-d',strtotime($endTime)+86400));
        }
        if($type == '1'){ // 消费
            $query = $query->where('consumed','>',0);
        }elseif($type == '2'){ //充值
            $query = $query->where('recharged','>',0);
        }
        $history = $query->orderBy('id','DESC')->paginate();

        return view('members.detail',compact('params','oneInfo','history'));
    }

    /**
     * 没有使用
     */
    public function edit($id)
    {
        //
    }

    /**
     * 充值或消费
     */
    public function update(Request $request, $id)
    {
        $money = floatval($request->get('money'));
        if($money <= 0) return back()->with('message','金额必须大于零');
        $type = intval($request->get('type'));
        if(!in_array($type,[1,2])){
            return back()->with('message','未知操作类型');
        }
        $remark = trim($request->get('remark'));
        $oneInfo = DB::table('members')->where('id',$id)->first();
        $data = ['updated_at'=>date('Y-m-d H:i:s')];
        $record = [
            'mobile' => $oneInfo->mobile,
            'created_at' => date('Y-m-d H:i:s')
        ];
        if($type == 1){
            if($oneInfo->balance < $money) return back()->with('message',"账户余额【{$oneInfo->balance}】不足抵扣消费金额【 $money 】");
            $data['consumed_total'] = $oneInfo->consumed_total + $money;
            $data['balance'] = $record['balance'] = $oneInfo->balance - $money;
            $record['consumed'] = $money;
            $record['remark'] = $remark ? $remark : '消费';
			
			$stInfo = $this->getSettle($request->input());
			
        }else{
            $data['recharged_total'] = $oneInfo->recharged_total + $money;
            $data['balance'] = $record['balance'] = $oneInfo->balance + $money;
            $record['recharged'] = $money;
            $record['remark'] = $remark ? $remark : '充值';;
        }
        $res = DB::table('members')->where('id',$id)->update($data);
        if($res){
			if(isset($stInfo)){
				DB::table('statements')->insert($stInfo);
			}
            DB::table('cash_records')->insert($record);
        }
        return redirect('/admin/members/'.$id)->with('message','操作成功');
    }

    /**
     * 挂失和解除挂失
     */
    public function destroy(Request $request, $id)
    {
        $frozen = intval($request->input('frozen')) ? 1 : 0;
        $res = DB::table('members')->where('id',intval($id))->update(['frozen'=>$frozen]);
        if($res){
            return back()->with('message','操作成功');
        }else{
            return back()->with('message','操作失败');
        }

    }

    public function checkMember($mobile){
        $oneInfo = DB::table('members')->where('mobile',$mobile)->where('frozen','!=',1)->first();
        if($oneInfo){
            if($oneInfo->frozen == 1){
                $data = ['errCode'=>2,'errMsg'=>'该账户被冻结','data'=>$oneInfo];
            }else{
                $data = ['errCode'=>0,'data'=>$oneInfo];
            }
        }else{
            $data = ['errCode'=>1,'errMsg'=>'账户不存在','data'=>[]];
        }
        return response()->json($data);
    }

    /*
     * 会员卡消费记录
     */
    public function showRecords(Request $request){

        $date = $request->get('date');
        $type = $request->get('type');
        $params = ['date'=>'','type'=>''];

        $query = DB::table('cash_records');
        if($date){
            $params['date'] = date('Y-m-d',strtotime($date));
            $stime = $params['date'].' 10:00:00';
            $query = $query->where('created_at','>=',$stime)
                ->where('created_at','<',date('Y-m-d H:i:s',strtotime($stime)+86400));
        }
        if(in_array($type,[1,2])){
            $params['type'] = $type;
            if($type == 1) $field = 'consumed';
            else $field = 'recharged';
            $query = $query->where($field,'>',0);
        }
        $records = $query->orderBy('id','DESC')->paginate();
        return view('members.records',compact('records','params'));
    }
	
	//获取结算信息
	public function getSettle($params){

        $tech_num =  intval($params['tech_num']);
        $price = floatval($params['money']);
        if($tech_num <= 0 || $price <=0){
            return back()->with('message','技师号和价格必填');
        }
        $extra = 0;
        $proj_name = trim($params['remark']);
        $service_time = date('Y-m-d H:i:s');
        $remark = trim($params['remark']);
        $data = compact('tech_num','price','proj_name','extra','service_time','remark');
        return $data;
    }
}
