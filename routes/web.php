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

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get( '/','SourcesteeringController@index' )->name('sourcesteering-index');
    Route::get('/home', 'SourcesteeringController@index' )->name('sourcesteering-index');



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

    Route::group(['prefix' => 'partner'], function () {
        Route::get( '/','PartnerController@index' )->name('partner-index');
        Route::post( 'delete','PartnerController@delete' )->name('partner-delete');
        Route::get( 'update','PartnerController@edit' )->name('partner-update');
        Route::post( 'update','PartnerController@update' )->name('partner-update');
    });

    Route::group(['prefix' => 'unit'], function () {
        Route::get( '/','UnitController@index' )->name('unit-index');
        Route::post( 'delete','UnitController@delete' )->name('unit-delete');
        Route::get( 'update','UnitController@edit' )->name('unit-update');
        Route::post( 'update','UnitController@update' )->name('unit-update');
    });

    Route::group(['prefix' => 'sourcesteering'], function () {
        Route::get( '/','SourcesteeringController@index' )->name('sourcesteering-index');
        Route::post( 'delete','SourcesteeringController@delete' )->name('sourcesteering-delete');
        Route::get( 'update','SourcesteeringController@edit' )->name('sourcesteering-update');
        Route::post( 'update','SourcesteeringController@update' )->name('sourcesteering-update');
    });

    Route::group(['prefix' => 'steeringcontent'], function () {
        Route::get( '/','SteeringcontentController@index' )->name('steeringcontent-index');
        Route::post( 'delete','SteeringcontentController@delete' )->name('steeringcontent-delete');
        Route::get( 'update','SteeringcontentController@edit' )->name('steeringcontent-update');
        Route::post( 'update','SteeringcontentController@update' )->name('steeringcontent-update');
    });


    Route::group(['prefix' => 'viphuman'], function () {
        Route::get( '/','ViphumanController@index' )->name('viphuman-index');
        Route::post( 'delete','ViphumanController@delete' )->name('viphuman-delete');
        Route::get( 'update','ViphumanController@edit' )->name('viphuman-update');
        Route::post( 'update','ViphumanController@update' )->name('viphuman-update');
    });


    Route::group(['prefix' => 'chucnang'], function () {
        Route::get( '/','ChucnangController@index' )->name('chucnang-index');
        Route::post( 'delete','ChucnangController@delete' )->name('chucnang-delete');
        Route::get( 'update','ChucnangController@edit' )->name('chucnang-update');
        Route::post( 'update','ChucnangController@update' )->name('chucnang-update');
    });

    Route::group(['prefix' => 'congviec'], function () {
        Route::get( 'daumoi','CongviecController@daumoi' )->name('congviec-daumoi');
        Route::get( 'phoihop','CongviecController@phoihop' )->name('congviec-phoihop');
        Route::get( 'duocgiao','CongviecController@duocgiao' )->name('congviec-duocgiao');
        Route::get( 'nguonchidao','CongviecController@nguonchidao' )->name('congviec-nguonchidao');
    });

});
