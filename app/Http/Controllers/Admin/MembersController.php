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
        if(isset($params['froze']) && $params['froze'] != ''){
            $query = $query->where('froze',intval($params['mobile']));
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
        $balance = $recharged_total = floatval($request->get('money'));
        $card_num = intval($request->get('card_num'));
        $created_at = date('Y-m-d H:i:s');
        $data = compact('mobile','balance','recharged_total','card_num','created_at');
        $res = DB::table('members')->insert($data);
        if($res){ // 记录账户余额变动
            $record = compact('mobile','balance');
            $record['recharged'] = $balance;
            $record['remark'] = '新开会员充值';
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
            $query = $query->where('created_at','<',date('Y-m-d',strtotime($endTime)+86500));
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
        $data = [];
        $record = ['mobile' => $oneInfo->mobile];
        if($type == 1){
            if($oneInfo->balance < $money) return back()->with('message',"账户余额【{$oneInfo->balance}】不足抵扣消费金额【$money】");
            $data['consumed_total'] = $oneInfo->consumed_total + $money;
            $data['balance'] = $record['balance'] = $oneInfo->balance - $money;
            $record['consumed'] = $money;
            $record['remark'] = $remark ? $remark : '消费';;
        }else{
            $data['recharged_total'] = $oneInfo->recharged_total + $money;
            $data['balance'] = $record['balance'] = $oneInfo->balance + $money;
            $record['recharged'] = $money;
            $record['remark'] = $remark ? $remark : '充值';;
        }
        $res = DB::table('members')->where('id',$id)->update($data);
        if($res){
            DB::table('cash_records')->insert($record);
        }
        return redirect('/admin/members/'.$id)->with('message','操作成功');
    }

    /**
     * 没有使用
     */
    public function destroy($id)
    {
        //
    }
}
