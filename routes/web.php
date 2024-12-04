<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'teamflow', 'namespace' => 'Falconmena\TfactoryTeamflow\Http\Controllers'], function () {
    Route::get('/send-message', 'SendMessageController@index');
});