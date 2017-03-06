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

Route::get('server/info', function(){
    echo phpinfo();
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::group(['middleware' => ['auth']], function () {
    Route::get('city/management', 'CityMunicipalityController@fetch');
    Route::get('/migrate', 'HomeController@migrate');
    Route::get('officer/management', 'OfficerController@fetch');
    Route::get('rescue/management', 'RescueController@fetch');
    Route::post('evacuation/management', 'EvacuationController@fetch');
    Route::post('evacuation/search', 'EvacuationController@search');
    Route::post('facility/management', 'FacilityController@fetch');
    Route::post('facilities/search', 'FacilityController@search');
    Route::post('province', 'ProvinceController@insert');
    Route::get('province/management', 'ProvinceController@fetchAdmin');
    Route::post('city/municipality', 'CityMunicipalityController@insert');
    Route::get('Provinces/All/Tabs/{id}', 'ProvinceController@fetchAlltabs');
    Route::post('officer', 'OfficerController@insert');
});
