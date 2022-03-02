<?php

use Illuminate\Support\Facades\Route;

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
    // skip welcome page
    return redirect( route('login') );
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('pages.dashboard');
    })->name('dashboard');

});

Route::middleware(['auth:sanctum', 'verified'])
    ->prefix("admin")
    ->as("admin")
    ->name("admin.")
    ->group(function (){

    Route::get('/dashboard', function () {
        return view('pages.dashboard');
    })->name('dashboard');

    Route::get('/users', function () {
        return view('cruds.user-crud.index');
    })->name('users');

    Route::get('/customers', function () {
        return view('cruds.customer-crud.index');
    })->name('customers');

    Route::get('/customers/{id}', function () {
        return view('cruds.customer-crud.details');
    })->name('customer');

});

