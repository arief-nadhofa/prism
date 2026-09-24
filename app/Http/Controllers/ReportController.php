<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    function index()
    {
        $title = 'Report';
        return view('pages.report.index', compact('title'));
    }
}
