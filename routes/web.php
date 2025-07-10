<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/blog', function () {
    return view('blog');
})->name('blog');

Route::get('/prodotti', function () {
    $products = config('molisana.pasta');
    // dd(compact('products'));
    return view('products', compact('products'));
})->name('products');
