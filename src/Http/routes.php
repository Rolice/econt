<?php

Route::group(['prefix' => 'econt'], function () {
    Route::get('zones', ['as' => 'econt.zones', 'uses' => 'Rolice\Econt\Http\Controllers\EcontController@zones']);
    Route::get('neighbourhoods', ['as' => 'econt.neighbourhoods', 'uses' => 'Rolice\Econt\Http\Controllers\EcontController@neighbourhoods']);

    Route::get('settlements', ['as' => 'econt.settlements', 'uses' => 'Rolice\Econt\Http\Controllers\SettlementController@index']);
    Route::get('settlements/autocomplete', [ 'as' => 'econt.settlements.autocomplete', 'uses' => 'Rolice\Econt\Http\Controllers\SettlementController@autocomplete']);

    Route::get('streets', ['as' => 'econt.streets', 'uses' => 'Rolice\Econt\Http\Controllers\StreetController@index']);
    Route::get('streets/autocomplete', ['as' => 'econt.streets.autocomplete', 'uses' => 'Rolice\Econt\Http\Controllers\StreetController@autocomplete']);

    Route::get('offices', ['as' => 'econt.offices', 'uses' => 'Rolice\Econt\Http\Controllers\Office@index']);
    Route::get('offices/dropdown', [ 'as' => 'econt.offices.dropdown', 'uses' => 'Rolice\Econt\Http\Controllers\OfficeController@dropdown']);

    Route::get('waybill', ['as' => 'econt.waybill', 'uses' => 'Rolice\Econt\Http\Controllers\WaybillController@issue']);
});