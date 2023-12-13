<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use COM;

class DataTransformController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:transform-list|transform-create|transform-edit|transform-delete', ['only' => ['index','show']]);
         $this->middleware('permission:transform-create', ['only' => ['create','store']]);
         $this->middleware('permission:transform-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:transform-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        return view('data_transform.index');
    }

    
}
