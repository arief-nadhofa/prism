<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\LineController;
use App\Http\Controllers\ProblemLogController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

Route::get('/', [LayoutController::class, 'index'])->name('/');

Route::post('proses-login', [AuthController::class, 'proses_login'])->name('proses-login');
Route::post('proses-logout', [AuthController::class, 'proses_logout'])->name('proses-logout');


Route::get('dashboard', [LayoutController::class, 'dashboard'])->name('dashboard');

Route::resource('problem-log', ProblemLogController::class);
// Halaman detail log problem
Route::get('/problem-log/{id}', [ProblemLogController::class, 'show'])->name('problem-log.show');

// Action untuk submit penutupan/close problem
Route::put('/problem-log/{id}/close', [ProblemLogController::class, 'closeProblem'])->name('problem-log.close');


Route::resource('line', LineController::class);

Route::resource('category', CategoryController::class);
Route::put('/category/{id}', [CategoryController::class, 'update'])->name('category.update');


Route::get('report.index', [ReportController::class, 'index'])->name('report.index');
