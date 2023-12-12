<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use COM;

class SalesmanController extends Controller
{

    public function index(Request $request)
    {
        return view('comming_soon');
    }
}