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

Route::get('/', 'HomeController@index');

Route::get('server/info', function(){
    echo phpinfo();
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::group(['middleware' => ['auth']], function () {
    Route::put('officer', 'OfficerController@update');
    Route::post('facility/fetch', 'FacilityController@fetch');
    Route::post('rescue/filterby/dropdown', 'RescueController@filter');
    Route::post('rescue/search', 'RescueController@searchOnly');
    Route::get('evacuations/download', 'EvacuationController@evacuationToExcel');
    Route::get('evacuations/export', 'EvacuationController@createExcelFile');
    Route::get('rescue/export', 'RescueController@export');
    Route::get('officer/download', 'OfficerController@export');
    Route::get('facility/download', 'FacilityController@export');
    Route::post('evacuation/skip/take', 'EvacuationController@scroll');
    Route::post('municipality/filterby/province', 'ProvinceController@getCities');
    Route::get('evacuations/filter/{pid}/{cit}', 'EvacuationController@filter');
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
    Route::delete('officer/{id}', 'OfficerController@delete');
    Route::get('officers/filter/province/{id}', 'OfficerController@filterBy');
    Route::post('officers/search', 'OfficerController@search');
});
