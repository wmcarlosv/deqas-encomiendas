<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShipmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[HomeController::class, 'store'])->name('store');
Route::get('/the_home/{shop_url?}/{access_token?}',[HomeController::class, 'the_home'])->name('the_home');
Route::get('/install',[HomeController::class, 'install'])->name('install');
Route::get('/print-sticker/{code}',[HomeController::class,'print_sticker'])->name('print_sticker');

Auth::routes();

Route::group(['prefix'=>'admin','middleware'=>array('auth')], function(){
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::resource('shipments',ShipmentController::class);
    Route::delete('/delete-multiple',[ShipmentController::class, 'delete_multiple'])->name('delete_multiple');
});

Route::post('/store-from-home',[ShipmentController::class, 'store_from_home'])->name('store_from_home');
Route::post('/update-from-home/{id}',[ShipmentController::class, 'update_from_home'])->name('update_from_home');
Route::get('/multiple-impresion/{ids}',[ShipmentController::class, 'multiple_impresion'])->name('multiple_impresion');
