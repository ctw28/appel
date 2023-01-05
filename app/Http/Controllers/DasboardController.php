<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserFakultas;

class DasboardController extends Controller
{
    //
    public function index()
    {
        $data['title'] = "Dashboard";
        // return view('template', $data);
        return view('admin.dashboard', $data);
    }
}
