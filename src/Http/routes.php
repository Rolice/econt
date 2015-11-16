<?php

Route::group(['prefix' => 'econt'], function () {
    Route::get('zones', ['as' => 'econt.zones', 'Rolice\Econt\Http\Controllers\EcontController@zones']);
    Route::get('settlements', ['as' => 'econt.settlements', 'Rolice\Econt\Http\Controllers\EcontController@settlements']);
    Route::get('neighbourhoods', ['as' => 'econt.neighbourhoods', 'Rolice\Econt\Http\Controllers\EcontController@neighbourhoods']);
    Route::get('streets', ['as' => 'econt.streets', 'Rolice\Econt\Http\Controllers\EcontController@streets']);
    Route::get('offices', ['as' => 'econt.offices', 'Rolice\Econt\Http\Controllers\EcontController@offices']);
});