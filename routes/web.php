<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/chi-siamo', function () {
    return view('pages.about');
})->name('about');

Route::get('/blog', function () {
    $posts = config('molisana.posts');
    return view('pages.blog', compact('posts'));
})->name('blog');

Route::get('/prodotti', function () {
    $products = config('molisana.pasta');
    // dd(compact('products'));
    return view('pages.products', compact('products'));
})->name('products');

Route::get('/contatti', function () {
    return view('pages.contacts');
})->name('contacts');

Route::get('/carrello', function () {
    return view('pages.cart');
})->name('cart');
