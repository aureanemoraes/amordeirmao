<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::get('admin/register', [App\Http\Controllers\Admin\Auth\RegisterController::class, 'showRegistrationForm'])
    ->name('backpack.auth.register')
    ->middleware('web');
//Route::get('admin/register', [App\Http\Controllers\Admin\Auth\RegisterController::class, 'showRegistrationForm'])->name('backpack.auth.register');


Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    //Route::get('admin/register', 'App\Http\Controllers\Auth\RegisterController')->name('backpack.auth.register');
    Route::crud('quality', 'QualityCrudController');
    Route::crud('director', 'DirectorCrudController');
    Route::crud('manager', 'ManagerCrudController');
    Route::crud('responsable', 'ResponsableCrudController');
    Route::crud('phone', 'PhoneCrudController');
    Route::crud('address', 'AddressCrudController');
    Route::crud('donatetype', 'DonateTypeCrudController');
    Route::crud('donate', 'DonateCrudController');
}); // this should be the absolute last line of this file
