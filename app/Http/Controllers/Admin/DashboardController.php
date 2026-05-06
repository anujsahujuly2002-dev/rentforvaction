<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Session;

class DashboardController extends Controller
{
    public function index () {
        return view('admin.dashboard');
    }

    // Logout Method
    public function logout(){
        Session::flush();
        Auth::logout();
        return to_route('admin.login')->with('success','Logout Successfully !');
    }
}
