<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('api.')->group(function() {
    Route::post('/register', 'APIController@register')->name('register');
    Route::post('/login', 'APIController@login')->name('login');
    Route::get('/thuong-hieu', 'APIController@thuongHieu')->name('thuonghieu');
    Route::get('/menu', 'APIController@menu')->name('menu');
    Route::post('/get-menu', 'APIController@getMenu')->name('getMenu');
    Route::post('/get-th', 'APIController@getTH')->name('getTH');
    Route::get('/the-loai', 'APIController@theLoai')->name('theloai');
    Route::post('/them-don-hang', 'APIController@themDonHang')->name('themDonHang');
    Route::post('/them-chi-tiet-don-hang', 'APIController@themChiTietDonHang')->name('themChiTietDonHang');
});
