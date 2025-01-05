<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PastebinDataController;
use App\Http\Controllers\PastebinErrorController;

Route::get('', function () {
    return view('welcome');
});

Route::get('/helloworld', function () {
    return response('Hello world!');
});

Route::get('/pastebins', [PastebinDataController::class, 'index'])->name('pastebins.index');
Route::get('/pastebin_errors', [PastebinErrorController::class, 'index'])->name('pastebin_errors.index');