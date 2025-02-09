<?php

use App\Http\Controllers\SmtpServerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('smtp', SmtpServerController::class);
Route::patch('/smtp/{id}/toggle', [SmtpServerController::class, 'toggleStatus'])->name('smtp.toggle');
