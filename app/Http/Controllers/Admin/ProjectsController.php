<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProjectsController extends Controller
{
    /**
     * 项目列表
     */
    public function index()
    {
        $projects = DB::table('projects')->get();
        return view('projects.index',compact('projects'));
    }

    // on use
    public function create()
    {
        //
    }

    /**
     * 新增项目存储
     */
    public function store(Request $request)
    {
        $proj_name = $request->get('proj_name');
        $price = floatval($request->get('price'));
        $time_spec = $request->get('time_spec')? intval($request->get('time_spec')) : 5;
        $remark = $request->get('remark') ? trim($request->get('remark')) : '';
        if(!is_string($proj_name) || strlen($proj_name) < 2){
            return back()->with('message','请输入至少2个字的项目名称');
        }
        if($price <= 0){
            return back()->with('message','请输入正确单价');
        }
        $data = compact('proj_name','price','time_spec','remark');
        if(DB::table('projects')->insert($data)){
            $msg = '添加成功';
        }else{
            $msg = '添加失败';
        }
        return back()->with('message',$msg);
    }

    //no use
    public function show($id)
    {
        //
    }

    // on use
    public function edit($id)
    {
        //
    }

    /**
     * 项目编辑
     */
    public function update(Request $request, $id)
    {
        $proj_name = $request->get('proj_name');
        $price = floatval($request->get('price'));
        $time_spec = $request->get('time_spec')? intval($request->get('time_spec')) : 5;
        $remark = $request->get('remark') ? trim($request->get('remark')) : '';
        if(!is_string($proj_name) || strlen($proj_name) < 2){
            return back()->with('message','请输入至少2个字的项目名称');
        }
        if($price <= 0){
            return back()->with('message','请输入正确单价');
        }
        $data = compact('proj_name','price','time_spec','remark');
        if(DB::table('projects')->where('id',$id)->update($data)){
            $msg = '添加成功';
        }else{
            $msg = '添加失败';
        }
        return back()->with('message',$msg);
    }

    /**
     * 删除项目
     */
    public function destroy($id)
    {
        if(DB::table('projects')->where('id',$id)->delete()){
            $msg = '添加成功';
        }else{
            $msg = '添加失败';
        }
        return back()->with('message',$msg);
    }
}
