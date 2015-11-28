<?php

Route::group(['prefix' => 'econt', 'middleware' => 'Rolice\Econt\Http\Middleware\Econt'], function () {
    Route::get('zones', ['as' => 'econt.zones', 'uses' => 'Rolice\Econt\Http\Controllers\EcontController@zones']);
    Route::get('neighbourhoods', ['as' => 'econt.neighbourhoods', 'uses' => 'Rolice\Econt\Http\Controllers\EcontController@neighbourhoods']);

    Route::post('test', ['as' => 'econt.test', 'uses' => 'Rolice\Econt\Http\Controllers\EcontController@test']);

    Route::get('settlements', ['as' => 'econt.settlements', 'uses' => 'Rolice\Econt\Http\Controllers\SettlementController@index']);
    Route::get('settlements/autocomplete', [ 'as' => 'econt.settlements.autocomplete', 'uses' => 'Rolice\Econt\Http\Controllers\SettlementController@autocomplete']);

    Route::get('streets', ['as' => 'econt.streets', 'uses' => 'Rolice\Econt\Http\Controllers\StreetController@index']);
    Route::get('streets/autocomplete', ['as' => 'econt.streets.autocomplete', 'uses' => 'Rolice\Econt\Http\Controllers\StreetController@autocomplete']);

    Route::get('offices', ['as' => 'econt.offices', 'uses' => 'Rolice\Econt\Http\Controllers\Office@index']);
    Route::get('offices/dropdown', [ 'as' => 'econt.offices.dropdown', 'uses' => 'Rolice\Econt\Http\Controllers\OfficeController@dropdown']);
    Route::get('offices/autocomplete', [ 'as' => 'econt.offices.autocomplete', 'uses' => 'Rolice\Econt\Http\Controllers\OfficeController@autocomplete']);
    Route::get('offices/autocomplete/name', [ 'as' => 'econt.offices.autocomplete.name', 'uses' => 'Rolice\Econt\Http\Controllers\OfficeController@autocompleteBySettlementName']);

    Route::post('waybill/issue', ['as' => 'econt.waybill.issue', 'uses' => 'Rolice\Econt\Http\Controllers\WaybillController@issue']);
    Route::post('waybill/calculate', [ 'as' => 'econt.waybill.calculate', 'uses' => 'Rolice\Econt\Http\Controllers\WaybillController@calculate']);

    Route::get('shipment/types', [ 'as' => 'econt.shipment.types', 'uses' => 'Rolice\Econt\Http\Controllers\ShipmentController@index']);
});