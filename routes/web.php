<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.auth.auth-login');
});

Route::middleware(['auth'])->group(function(){
    Route::get('home', function() {
        return view('pages.dashboard', ['type_menu' => 'home']);
    })->name('home');
});

route::resource('users', UserController::class);
Route::resource('companies', CompanyController::class);
