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
    return redirect()->route('backpack.auth.login');
});

Route::get('/not_validated', function () {
    return view('not_validated');
})->name('not_valid');

Route::post('cep', function(\Illuminate\Http\Request $request){
    $cepResponse = cep($request->zip_code);
    $data = $cepResponse->getCepModel();
    return response()->json($data);
});

