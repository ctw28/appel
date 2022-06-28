<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DasboardController extends Controller
{
    //
    public function index()
    {
        $data['title'] = "Dashboard";
        return view('admin.dashboard', $data);
        // return view('template', $data);
    }
}
