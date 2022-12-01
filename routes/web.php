<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/link-storage', function () {
    Artisan::call('storage:link');
});

Route::middleware(['auth'])->prefix('admin')->name('backend.')->namespace('Backend')->group(function () {
    Route::redirect('/dashboard', '/menu')->name('home');
    Route::prefix('menu')->name('menu.')->group(function () {
        Route::get('/', 'MenuController@index')->name('index');
        Route::post('/search', 'MenuController@search')->name('search');
        Route::post('/detail/{id}', 'MenuController@detail')->name('detail');
        Route::post('/get-data', 'MenuController@getData')->name('get-data');
    });
    Route::prefix('the-loai')->name('the_loai.')->group(function () {
        Route::match(['get', 'post'], '/', 'TheLoaiController@index')->name('index');
        Route::post('/create', 'TheLoaiController@create')->name('create');
        Route::post('/store', 'TheLoaiController@store')->name('store');
        Route::post('/edit/{id}', 'TheLoaiController@edit')->name('edit');
        Route::put('/update/{id}', 'TheLoaiController@update')->name('update');
        Route::delete('/delete/{id}', 'TheLoaiController@delete')->name('delete');
    });
    Route::prefix('san-pham')->name('san_pham.')->group(function () {
        Route::match(['get', 'post'], '/', 'SanPhamController@index')->name('index');
        Route::post('/create', 'SanPhamController@create')->name('create');
        Route::post('/store', 'SanPhamController@store')->name('store');
        Route::post('/edit/{id}', 'SanPhamController@edit')->name('edit');
        Route::put('/update/{id}', 'SanPhamController@update')->name('update');
        Route::delete('/delete/{id}', 'SanPhamController@delete')->name('delete');
    });
    Route::prefix('cart')->name('cart.')->group(function () {
        // Route::get('/', 'CartController@index')->name('index');
        // Route::post('/search', 'MenuController@search')->name('search');
        Route::get('/', 'CartController@index')->name('index');
        Route::post('/add', 'CartController@add')->name('add');
        Route::put('/update', 'CartController@update')->name('update');
        Route::post('/remove', 'CartController@remove')->name('add');
    });

    Route::prefix('order')->name('order.')->group(function () {
        Route::get('/', 'OrderController@index')->name('index');
        Route::post('/get-data', 'OrderController@getData')->name('get-data');
        Route::post('/order', 'OrderController@order')->name('order');
        Route::get('/placed', 'OrderController@placed')->name('placed');
        Route::post('/placed-detail', 'OrderController@placedDetail')->name('order');
    });

    Route::prefix('admin')->name('admin.')->middleware('can:check-user-is-admin')->group(function () {
        Route::get('/', 'AdminController@index')->name('index');
        Route::get('/order-placed', 'OrderController@placed')->name('order-placed');
        Route::get('/products/', 'AdminController@product')->name('product.index');
        Route::post('products/search', 'AdminController@search')->name('product.search');
        Route::post('products/detail/{id}', 'AdminController@detail')->name('detail');
        Route::post('products/add', 'AdminController@add')->name('add');
        Route::post('products/store', 'AdminController@store')->name('store');
        Route::post('products/edit/{id}', 'AdminController@edit')->name('edit');
        Route::post('products/update/{id}', 'AdminController@update')->name('edit');
        Route::delete('products/delete', 'AdminController@delete')->name('delete');
    });
});

Route::namespace('Frontend')->name('frontend.')->group(function () {
    // Route::redirect('/dashboard', '/menu')->name('home');
    Route::name('index.')->group(function () {
        Route::get('/', 'IndexController@index')->name('index');
        Route::post('/get-hang-moi-ve', 'IndexController@getHangMoiVe')->name('new_product');
    });
    Route::prefix('the-loai')->name('the_loai.')->group(function () {
        Route::match(['get', 'post'], '/{slug}', 'TheLoaiController@index')->name('index');
    });
    Route::prefix('san-pham')->name('san_pham.')->group(function () {
        Route::match(['get', 'post'], '/{san_pham_slug}', 'SanPhamController@index')->name('index');
        Route::post('/create', 'SanPhamController@create')->name('create');
    });

    Route::name('cart.')->group(function () {
        Route::get('/get-cart', 'CartController@index')->name('index');
        Route::post('/add-cart', 'CartController@add');
    });
});





require __DIR__ . '/auth.php';
