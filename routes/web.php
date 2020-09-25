<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('index');
});

//見える化の機械加工部分
Route::prefix('mieru/nc')->group(function(){
    Route::namespace('Mieru\Ncs')->group(function(){

        //ユーザーログインが必要
        Route::group(['middleware' => ['auth', 'can:user-higher']],function(){

        });

        Route::get('/products/{product_no}', 'NcsController@show')->name('mieru.ncs.show');
        Route::get('', 'NcsController@index')->name('mieru.ncs.index');
    });
});



Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
