<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'teamflow'], function () {
    Route::get('/get-message', [TfactoryTeamflow\Http\Controllers\SendMessageController::class, 'index'])->name('teamflow.message.index');
    Route::post('/send-message', [TfactoryTeamflow\Http\Controllers\SendMessageController::class, 'store'])->name('teamflow.message.store');
});