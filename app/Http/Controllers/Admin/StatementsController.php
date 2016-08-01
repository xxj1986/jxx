<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class StatementsController extends Controller
{
    /**
     * 日流水查看
     */
    public function index(Request $request)
    {
        $mode = $request->get('mode');
        if(!in_array($mode,['view','record'])){
            $mode = 'view';
        }
        $last = DB::table('statements')->orderBy('service_time','DESC')->first();
        if($last){
            $date = substr($last->service_time,0,10);
            $start = $date.' 10:00';
            $end = date('Y-m-d',strtotime($date)+86400+36000-1); //计算到第二天9点59分
            $query = DB::table('statements')->where('service_time','between',[$start,$end]);
            if($mode == 'record'){
                $statements = $query->orderBy('service_time','DESC')->get(8);
            }else{
                $statements = $query->get();
            }
            $statements = $statements->keyBy('service_time');
            sort($statements);
        }else{
            $date = Date('Y-m-d');
            $statements = [];
        }
        $params = compact('mode','date');
        $techs  =  DB::table('users')->where('role','技师')->lists('tech_num');

        return view('statements.index',compact('params','statements','techs'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
