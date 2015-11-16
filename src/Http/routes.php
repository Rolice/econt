<?php

Route::group(['prefix' => 'econt'], function () {
    Route::get('zones', ['as' => 'econt.zones', 'EcontController@zones']);
});