<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class StatementsController extends Controller
{
    /**
     *
     */
    public function index(Request $request)
    {
        $last = DB::table('statements')->orderBy('service_time','DESC')->first();
        if($last){
//            $date = substr($last->service_time,0,10);
//            $start = $date.' 10:00';
//            $end = date('Y-m-d',strtotime($date)+86400+36000-1); //计算到第二天9点59分
            $query = DB::table('statements')->select('tech_num', DB::raw('SUM(price) as total_sales, COUNT(id) as total_num'));
            $statements =  $query->groupBy('tech_num')->paginate(20);
            $statements = $statements->keyBy('tech_num');
        }else{
            $date = Date('Y-m-d');
            $statements = [];
        }

        $techs = DB::table('users')->where('role','技师')->get();

        return view('statements.month',compact('statements','techs'));

    }

    /*
     * 日流水查看
     */
    public function daily(Request $request){
        $mode = $request->get('mode');
        if(!in_array($mode,['view','record'])){
            $mode = 'view';
        }
        $last = DB::table('statements')->orderBy('service_time','DESC')->first();
        if($last){
            $date = substr($last->service_time,0,10);
            $start = $date.' 10:00';
            $end = date('Y-m-d',strtotime($date)+86400+36000-1); //计算到第二天9点59分
            $query = DB::table('statements')->where('service_time','>=',$start)->where('service_time','<=',$end);
            if($mode == 'record'){
                $statements = $query->orderBy('service_time','DESC')->limit(8)->get();
            }else{
                $statements = $query->get();
            }
//            $statements = $statements->keyBy('service_time');
//            sort($statements);
        }else{
            $date = Date('Y-m-d');
            $statements = [];
        }
        $params = compact('mode','date');
        $techs  =  DB::table('users')->where('role','技师')->lists('tech_num');

        return view('statements.index',compact('params','statements','techs'));
    }

    /**
     *  no use
     */
    public function create()
    {

    }

    /**
     * 上钟记录存储
     */
    public function store(Request $request)
    {
        $data = $this->getInputs($request->input());
        $res = DB::table('statements')->insert($data);
        $msg = $res ? '保存成功' : '保存失败' ;
        return back()->withInput()->with('message',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 更改存储
     */
    public function update(Request $request, $id)
    {
        $data = $this->getInputs($request->input());
        $res = DB::table('statements')->where('id',$id)->update($data);
        $msg = $res ? '更改成功' : '更改失败' ;
        return back()->withInput()->with('message',$msg);
    }

    /**
     * 删除
     */
    public function destroy($id)
    {
        $res = DB::table('statements')->where('id',$id)->delete();
        $msg = $res ? '删除成功' : '删除失败' ;
        return back()->with('message',$msg);
    }

    public function getInputs($params){

        $tech_num =  intval($params['tech_num']);
        $price = floatval($params['price']);
        if($tech_num <= 0 || $price <=0){
            return back()->with('message','技师号和价格必填');
        }
        $extra = floatval($params['extra']);
        $proj_name = trim($params['proj_name']);
        $service_time = $params['date'].' '.$params['hour'].':'.$params['minute'].':00';
        $remark = trim($params['remark']);
        $data = compact('tech_num','price','proj_name','extra','service_time','remark');
        return $data;
    }
}
