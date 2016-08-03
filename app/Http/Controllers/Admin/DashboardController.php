<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB,Auth;

class DashboardController extends Controller
{
    public function index(){
        $userNum = DB::table('users')->count();
        if($userNum == 1 && Auth::user()->role != '超级管理员'){
            DB::table('users')->where('id',Auth::user()->id)->update(['role'=>'超级管理员']);
        }
        return view('dashboard.dashboard');
    }
}
