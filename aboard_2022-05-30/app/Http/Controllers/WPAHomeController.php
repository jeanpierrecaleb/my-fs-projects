<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WPAHomeController extends Controller
{
    //


    public function index(){

        return view('planning.wpaboard');

    }
}
