<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController as HomeController;
use App\Http\Controllers\AboutController as AboutController;
use App\Http\Controllers\ProductsController as ProductsController;
use App\Http\Controllers\BlogController as BlogController;
use App\Http\Controllers\ContactsController as ContactsController;
use App\Http\Controllers\CartController as CartController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/chi-siamo', [AboutController::class, 'index'])->name('about');

Route::get('/blog', function () {
    $posts = config('molisana.posts');
    return view('pages.blog', compact('posts'));
})->name('blog');
// Route::get('/blog', [BlogController::class, 'index'])->name('blog');


// Route::get('/prodotti', function () {
//     $products = config('molisana.pasta');
//     // dd(compact('products'));
//     return view('pages.products', compact('products'));
// })->name('products');
Route::get('/prodotti', [ProductsController::class, 'index'])->name('products');
Route::get('/prodotti/{product}', [ProductsController::class, 'show'])->name('singleproduct');

Route::get('/contatti', [ContactsController::class, 'index'])->name('contacts');

Route::get('/carrello', [CartController::class, 'index'])->name('cart');
