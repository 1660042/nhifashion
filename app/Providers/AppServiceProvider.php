<?php

namespace App\Providers;

use App\Models\TheLoai;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        View::composer(['frontend.layouts.header'], function ($view) {
            $theLoaiModel = new TheLoai();
            $dsTheLoai = $theLoaiModel->with(['theLoaiCon'])->get();
            $view->with('dsTheLoai', $dsTheLoai);
        });
    }
}
