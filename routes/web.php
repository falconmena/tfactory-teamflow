<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'teamflow'], function () {
    Route::get('/get-message', [Techsfactory\TfactoryTeamflow\Http\Controllers\MessageController::class, 'index'])->name('teamflow.message.index');
    Route::post('/send-message', [Techsfactory\TfactoryTeamflow\Http\Controllers\MessageController::class, 'send'])->name('teamflow.message.store');
    
    Route::post('/get-logs/{id}/{type}', [Techsfactory\TfactoryTeamflow\Http\Controllers\MessageController::class, 'get_logs'])->name('teamflow.logs.get');

    Route::post('/attachments/store', [Techsfactory\TfactoryTeamflow\Http\Controllers\AttachmentController::class, 'store'])->name('teamflow.attachment.store');
    Route::get('/attachments/recent', [Techsfactory\TfactoryTeamflow\Http\Controllers\AttachmentController::class, 'getRecentFiles'])->name('teamflow.attachment.recent');
    Route::delete('/attachments/delete/{id}', [Techsfactory\TfactoryTeamflow\Http\Controllers\AttachmentController::class, 'delete'])->name('teamflow.attachment.delete');

    Route::post('/activity/store', [Techsfactory\TfactoryTeamflow\Http\Controllers\ActivityController::class, 'store'])->name('teamflow.activity.store');
    Route::get('/activity', [Techsfactory\TfactoryTeamflow\Http\Controllers\ActivityController::class, 'getActivity'])->name('teamflow.activity.get');
    Route::delete('/activity/delete/{id}', [Techsfactory\TfactoryTeamflow\Http\Controllers\ActivityController::class, 'delete'])->name('teamflow.activity.delete');
});