<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes for Admin area
|--------------------------------------------------------------------------
|
*/

Route::middleware(['auth:sanctum', 'verified', "only.admin"])
    ->prefix("admin")
    ->as("admin")
    ->name("admin.")
    ->group(function (){

        Route::get('/dashboard', function () {
            return view('pages.dashboard');
        })->name('dashboard');

        Route::get('/users', function () {
            return view('pages.default-index',
                [
                    "headline" => __("Admin"). " ". __("Users").' <b>C</b><small>reate</small><b>R</b><small>ead</small><b>U</b><small>pdate</small><b>D</b><small>elete</small>',
                    "crud" => "cruds.admin.user-crud"
                ]);
        })->name('users');

        Route::get('/customers', function () {
            return view('pages.default-index',
                [
                    "headline" => __("Customer").' <b>C</b><small>reate</small><b>R</b><small>ead</small><b>U</b><small>pdate</small><b>D</b><small>elete</small>',
                    "crud" => "cruds.admin.customer-crud"
                ]);
        })->name('customers');

        Route::get('/customers/{id}', function () {
            return view('cruds.customer-crud.details');
        })->name('customer');

    });
