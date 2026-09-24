<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LayoutController extends Controller
{
    function index()
    {
        return view('pages.login');
    }

    function dashboard()
    {
        return view('pages.dashboard.dashboard');
    }
}
