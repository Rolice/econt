<?php

Route::group(['prefix' => 'econt'], function () {
    Route::get('zones', ['as' => 'econt.zones', 'uses' => 'Rolice\Econt\Http\Controllers\EcontController@zones']);
    Route::get('settlements', ['as' => 'econt.settlements', 'uses' => 'Rolice\Econt\Http\Controllers\EcontController@settlements']);
    Route::get('neighbourhoods', ['as' => 'econt.neighbourhoods', 'uses' => 'Rolice\Econt\Http\Controllers\EcontController@neighbourhoods']);
    Route::get('streets', ['as' => 'econt.streets', 'uses' => 'Rolice\Econt\Http\Controllers\EcontController@streets']);

    Route::get('offices', ['as' => 'econt.offices', 'uses' => 'Rolice\Econt\Http\Controllers\Office@index']);
    Route::get('offices/dropdown', [ 'as' => 'econt.offices.dropdown', 'uses' => 'Rolice\Econt\Http\Controllers\OfficeController@dropdown']);

    Route::get('waybill', ['as' => 'econt.waybill', 'uses' => 'Rolice\Econt\Http\Controllers\WaybillController@issue']);
});