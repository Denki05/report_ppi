<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use DB;

class LogoutController extends Controller
{
    /**
     * Log out account user.
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function perform()
    {

        DB::table('report_type')->truncate();
        DB::table('report_type_detail')->truncate();

        Session::flush();
        
        Auth::logout();

        return redirect('login');
    }
}
