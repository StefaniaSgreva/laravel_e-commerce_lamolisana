<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/news', function () {
    return view('blog');
})->name('blog');

Route::get('/prodotti', function () {
    return view('products');
})->name('products');
