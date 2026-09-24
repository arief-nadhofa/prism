<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    function proses_login()
    {
        return redirect()->to('dashboard');
    }

    function proses_logout()
    {
        return redirect()->to('/');
    }
}
