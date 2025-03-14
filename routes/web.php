<?php

use App\Http\Controllers\Dropdowncontroller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admincontroller;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Refcodecontroller;
use App\Http\Middleware\CheckStatus;
use App\Http\Middleware\CheckInventory;
use App\Http\Controllers\ImportItemController;

Route::get('/', function () {
    return view('welcome');
});

// Taking


//import
Route::post('/import', [Admincontroller::class, 'importrefcode']); //import sitecode
Route::get('/import', [Admincontroller::class, 'importrefcode']);  //import sitecode

// save import
Route::get('/saveImport', [Admincontroller::class, 'saveAdd']);  //import Save
Route::post('/saveImport', [Admincontroller::class, 'saveAdd']); //import Save


Route::get('/blog', [Admincontroller::class, 'index'])->name('blog')->middleware(CheckStatus::class);
Route::get('edit/{id}', [Admincontroller::class, 'edit'])->name('edit');
Route::post('update/{id}', [Admincontroller::class, 'update'])->name('update');

Route::get('add', [Admincontroller::class, 'add'])->name('add');
Route::post('insert', [Admincontroller::class, 'insert'])->name('insert');

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/register', [RegisterController::class, 'register'])->name('register');             // status = 4
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register'); // status = 4


//test

Route::get('/test/are', [Dropdowncontroller::class, 'total'])->name('are');
Route::get('/test/user', [Dropdowncontroller::class, 'user'])->name('user');

// Search Refcode

    //export
Route::get('/refcode', [RefcodeController::class, 'index'])->name('refcode.index');

Route::get('refcode/home', [Refcodecontroller::class, 'index']);
Route::get('/search-refcode', [RefcodeController::class, 'searchRefcode'])->name('searchRefcode');

//import refcode

Route::get('refcode/importrefcode', [Refcodecontroller::class, 'importrefcode']);
Route::post('refcode/importrefcode', [Refcodecontroller::class, 'importrefcode']);

//save refcode

Route::get('refcode/saverefcode', [Refcodecontroller::class, 'saveAdd']);
Route::post('refcode/saverefcode', [Refcodecontroller::class, 'saveAdd']);

// Inventory

// หน้า import add
Route::get('/import', [ImportItemController::class, 'index'])->middleware(CheckInventory::class);
Route::get('/check-refcode', [ImportItemController::class, 'checkRefcode'])->name('check.refcode')->middleware(CheckInventory::class);
Route::get('/check-import', [ImportItemController::class, 'checkImport_add'])->name('check.import')->middleware(CheckInventory::class);

Route::get('/import', [ImportItemController::class, 'material'])->name('import_get')->middleware(CheckInventory::class);

// กด import add
Route::post('/importadd', [ImportItemController::class, 'additem'])->name('importadd')->middleware(CheckInventory::class);
Route::get('/importadd', [ImportItemController::class, 'additem'])->name('importadd')->middleware(CheckInventory::class);

//หน้า Refcode
Route::post('/addrefcode', [ImportItemController::class, 'import_refcode'])->name('addrefcode')->middleware(CheckInventory::class);
Route::get('/addrefcode', [ImportItemController::class, 'import_refcode'])->name('addrefcode')->middleware(CheckInventory::class);

Route::post('/saveadd', [ImportItemController::class, 'saveAdd'])->name('saveadd')->middleware(CheckInventory::class);
Route::get('/saveadd', [ImportItemController::class, 'saveAdd'])->name('saveadd')->middleware(CheckInventory::class);
// add refcodemanual
Route::post('/addrefcodemanual', [ImportItemController::class, 'addrefcodemanual'])->middleware(CheckInventory::class);

//หน้า Material
Route::get('/material', [ImportItemController::class, 'import_material'])->name('material')->middleware(CheckInventory::class);
Route::post('/material', [ImportItemController::class, 'import_material'])->name('material')->middleware(CheckInventory::class);

Route::get('/savematerial', [ImportItemController::class, 'savematerial'])->name('savematerial')->middleware(CheckInventory::class);
Route::post('/savematerial', [ImportItemController::class, 'savematerial'])->name('savematerial')->middleware(CheckInventory::class);
//Add Material 
Route::post('/addmaterialmanual', [ImportItemController::class, 'addmaterialmanual'])->name('addmaterialmanual')->middleware(CheckInventory::class);

//Droppoint
Route::get('/droppoint', [ImportItemController::class, 'droppoint'])->name('droppoint')->middleware(CheckInventory::class);
//add
Route::get('/Adddroppoint', [ImportItemController::class, 'addDroppoint'])->name('Adddroppoint')->middleware(CheckInventory::class);
Route::post('/Adddroppoint', [ImportItemController::class, 'addDroppoint'])->name('Adddroppoint')->middleware(CheckInventory::class);
//import
Route::post('/droppoint', [ImportItemController::class, 'import_droppoint'])->name('droppoint')->middleware(CheckInventory::class);
Route::get('/droppoint', [ImportItemController::class, 'import_droppoint'])->name('droppoint')->middleware(CheckInventory::class);
//save
Route::get('/savedroppoint', [ImportItemController::class, 'savedroppoint'])->name('savematerial')->middleware(CheckInventory::class);
Route::post('/savedroppoint', [ImportItemController::class, 'savedroppoint'])->name('savematerial')->middleware(CheckInventory::class);

//withdraw
Route::get('/withdraw', [ImportItemController::class, 'withdraw'])->name('withdraw')->middleware(CheckInventory::class);

Route::post('/withdrawAdd', [ImportItemController::class, 'addWithdraw'])->name('withdrawAdd')->middleware(CheckInventory::class);

//SUM
Route::get('/sum', [ImportItemController::class, 'summary'])->name('sum')->middleware(CheckInventory::class);

//Region
Route::get('/region', [ImportItemController::class, 'region'])->middleware(CheckInventory::class);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
