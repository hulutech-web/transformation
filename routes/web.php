<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
//    return view("app");
    return redirect('/admin/index');
});
Route::get('/goods/{goods}/show', function () {
    return view('app');
});
Route::get('/cart', function () {
    return view('app');
});
//系统应用
Route::get('{admin}/{path?}', function () {
    return view('admin');
})->where('admin', 'admin|auth')->where('path', '.*');
