<?php

use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontController::class, 'index'])->name('pages.index');
Route::get('/search', [FrontController::class, 'search'])->name('pages.search');
Route::get('/store/details/{carStore:slug}', [FrontController::class, 'detail'])->name('pages.detail');
