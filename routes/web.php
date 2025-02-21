<?php

use App\Http\Controllers\Dropdowncontroller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admincontroller;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Refcodecontroller;
use App\Http\Middleware\CheckStatus;

Route::get('/', function () {
    return view('welcome');
});

// Taking

Route::get('/blog', [Admincontroller::class, 'index'])->name('blog')->middleware(CheckStatus::class); 
Route::get('edit/{id}', [Admincontroller::class, 'edit'])->name('edit'); 
Route::post('update/{id}', [Admincontroller::class,'update'])->name('update');

Route::get('add', [Admincontroller::class,'add'])->name('add');
Route::post('insert', [Admincontroller::class,'insert'])->name('insert');

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/register',[RegisterController::class, 'register'])->name('register');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

//test
Route::get('/test/are', [Dropdowncontroller::class, 'total'])->name('are');
Route::get('/test/user', [Dropdowncontroller::class, 'user'])->name('user');


// Search Refcode
Route::get('refcode/home',[Refcodecontroller::class, 'index']);

Route::get('refcode/importrefcode', [Refcodecontroller::class,'importrefcode']);
Route::post('refcode/importrefcode', [Refcodecontroller::class,'importrefcode']);

Route::get('refcode/saverefcode',[Refcodecontroller::class,'saveAdd']);
Route::post('refcode/saverefcode',[Refcodecontroller::class,'saveAdd']);



