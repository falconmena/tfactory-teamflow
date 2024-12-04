<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'teamflow'], function () {
    Route::get('/get-message', [Falconmena\TfactoryTeamflow\Http\Controllers\SendMessageController::class, 'index'])->name('message.index');
    Route::post('/send-message', [Falconmena\TfactoryTeamflow\Http\Controllers\SendMessageController::class, 'store'])->name('message.store');
});