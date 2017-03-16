<?php

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
    return view('welcome');
});

Route::get('home', 'IndexController@home');

Route::group(['prefix' => 'nguoidung'], function () {
    Route::get( '/','NguoidungController@index' )->name('nguoidung-index');
    Route::post( 'delete','NguoidungController@delete' )->name('nguoidung-delete');
    Route::get( 'update','NguoidungController@edit' )->name('nguoidung-update');
    Route::post( 'update','NguoidungController@update' )->name('nguoidung-update');
    Route::get( 'add','NguoidungController@addform' )->name('nguoidung-add');
    Route::post( 'add','NguoidungController@add' )->name('nguoidung-add');
});

Route::group(['prefix' => 'user'], function () {
    Route::get( '/','UserController@index' )->name('user-index');
    Route::post( 'delete','UserController@delete' )->name('user-delete');
    Route::get( 'update','UserController@edit' )->name('user-update');
    Route::post( 'update','UserController@update' )->name('user-update');
});

Route::group(['prefix' => 'group'], function () {
    Route::get( '/','GroupController@index' )->name('group-index');
    Route::post( 'delete','GroupController@delete' )->name('group-delete');
    Route::get( 'update','GroupController@edit' )->name('group-update');
    Route::post( 'update','GroupController@update' )->name('group-update');
});