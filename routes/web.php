<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/blog', function () {
    $posts = config('molisana.posts');
    return view('blog', compact('posts'));
})->name('blog');

Route::get('/prodotti', function () {
    $products = config('molisana.pasta');
    // dd(compact('products'));
    return view('products', compact('products'));
})->name('products');
