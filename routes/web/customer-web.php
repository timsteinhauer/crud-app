<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes for Customer area
|--------------------------------------------------------------------------
|
*/

Route::middleware(['auth:sanctum', 'verified', 'only.customer'])
    ->as("customer")
    ->name("customer.")
    ->group(function (){

        Route::get('/dashboard', function () {
            return view('pages.dashboard');
        })->name('dashboard');


        Route::get('/users', function () {
            return view('pages.default-index',
                [
                    "headline" => __("Users").' <b>C</b><small>reate</small><b>R</b><small>ead</small><b>U</b><small>pdate</small><b>D</b><small>elete</small>',
                    "crud" => "cruds.customer.user-crud"
                ]);
        })->name('users');


    });
