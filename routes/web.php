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

    Route::get( '/','SteeringcontentController@index' )->name('steeringcontent-index');
    Route::get( '/home','SteeringcontentController@index' )->name('steeringcontent-index');
    Route::get('/errpermission', function () {
        return view('errpermission');
    });


    Route::group(['prefix' => 'user'], function () {
        Route::get( '/','UserController@index' )->name('user-index');
        Route::post( 'delete','UserController@delete' )->name('user-delete');
        Route::get( 'update','UserController@edit' )->name('user-update');
        Route::post( 'update','UserController@update' )->name('user-update');
        Route::post( 'changepass','UserController@changepass' )->name('user-changepass');
        Route::get( 'changepass','UserController@changepass' )->name('user-changepass');
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


    Route::group(['prefix' => 'xuly'], function () {
        Route::get( '/daumoi','XuLyCVController@daumoi' )->name('xuly-daumoi');
        Route::get( '/phoihop','XuLyCVController@phoihop' )->name('xuly-phoihop');
        Route::get( '/duocgiao','XuLyCVController@duocgiao' )->name('xuly-duocgiao');
        Route::get( '/nguonchidao','XuLyCVController@nguonchidao' )->name('xuly-nguonchidao');
        Route::post( 'nhancongviec','XuLyCVController@nhancongviec' )->name('xuly-nhancongviec');
        Route::get( 'updatecv','XuLyCVController@updatecv' )->name('xuly-updatecv');
        Route::post( 'updatecv','XuLyCVController@updatecv' )->name('xuly-updatecv');
        Route::get( 'tranfer','XuLyCVController@tranfer' )->name('xuly-tranfer  ');

    });

    Route::group(['prefix' => 'chucnang'], function () {
        Route::get( '/','ChucnangController@index' )->name('chucnang-index');
        Route::post( 'delete','ChucnangController@delete' )->name('chucnang-delete');
        Route::get( 'update','ChucnangController@edit' )->name('chucnang-update');
        Route::post( 'update','ChucnangController@update' )->name('chucnang-update');
    });

    Route::group(['prefix' => 'report'], function () {
        Route::get( '/','ReportController@index' )->name('report-index');
        Route::post( '/','ReportController@index' )->name('report-index');
        Route::get( '/export','ReportController@export' )->name('export-index');
    });
    Route::group(['prefix' => 'api'], function () {
        Route::get('progress', 'ApiController@getProgress');
        Route::get('updateprogress', 'ApiController@updateProgress');
        Route::post( 'updateprogress','ApiController@addProgress' )->name('add-progress');
        Route::post( 'tranfer','ApiController@tranfer' )->name('steering-tranfer');
    });

});
