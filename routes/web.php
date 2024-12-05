<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'teamflow'], function () {
    Route::get('/get-message', [Techsfactory\TfactoryTeamflow\Http\Controllers\MessageController::class, 'index'])->name('teamflow.message.index');
    Route::post('/send-message', [Techsfactory\TfactoryTeamflow\Http\Controllers\MessageController::class, 'send'])->name('teamflow.message.store');
    
    Route::post('/get-logs', [Techsfactory\TfactoryTeamflow\Http\Controllers\MessageController::class, 'get_logs'])->name('teamflow.logs.get');

    Route::get('/get-attachments', [Techsfactory\TfactoryTeamflow\Http\Controllers\AttachmentController::class, 'index'])->name('teamflow.attachment.index');
    Route::post('/store-attachment', [Techsfactory\TfactoryTeamflow\Http\Controllers\AttachmentController::class, 'store'])->name('teamflow.attachment.store');

});