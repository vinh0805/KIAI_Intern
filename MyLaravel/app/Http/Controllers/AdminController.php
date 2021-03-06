<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();


class AdminController extends Controller
{
    public function authLogin()
    {
        $admin_id = Session::get('admin_id');
        if (isset($admin_id)) {
            return redirect('dashboard');
        } else {
            return redirect('admin')->send();
        }
    }

    public function index()
    {
//        $this->authLogin();
        return view('admin_login');
    }

    public function showDashboard()
    {
        $this->authLogin();
        return view('admin.dashboard');
    }

    public function dashboard(Request $request)
    {
        $this->authLogin();
        $admin_email = $request->admin_email;
        $admin_password = md5($request->admin_password);

        $result = DB::table('tbl_admin')->where('admin_email', $admin_email)->where('admin_password', $admin_password)->first();
        if($result) {
            Session::put('admin_name', $result->admin_name);
            Session::put('admin_id', $result->admin_id);
            return Redirect::to('/dashboard');
        } else {
            Session::put('message', 'Wrong account or password!!');
            return Redirect::to('/admin');
        }
    }

    public function logout()
    {
        $this->authLogin();
        Session::put('admin_name', null);
        Session::put('admin_id', null);
        return Redirect::to('admin');
    }
}



