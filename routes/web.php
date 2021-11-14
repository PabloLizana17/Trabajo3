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
    return view('inicio');
});
Route::get('afd', function () {
    return view('afd');
});
Route::get('afd_recoleccion', function () {
    return view('afd_recoleccion');
});
Route::get('afd_final', function () {
    return view('afd_final');
});
Route::get('afd_resultados', function () {
    return view('afd_resultados');
});
Route::get('ap', function () {
    return view('ap');
});
Route::get('ap_recoleccion1', function () {
    return view('ap_recoleccion1');
});Route::get('ap_final1', function () {
    return view('ap_final1');
});
Route::get('ap2', function () {
    return view('ap2');
});
Route::get('ap_recoleccion2', function () {
    return view('ap_recoleccion2');
});
Route::get('ap_final2', function () {
    return view('ap_final2');
});
Route::get('ap_resultados', function () {
    return view('ap_resultados');
});
