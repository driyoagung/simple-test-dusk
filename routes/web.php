<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/products'); // Redirect ke products
});

Route::resource('products', ProductController::class);