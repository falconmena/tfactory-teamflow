<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'teamflow'], function () {
    Route::get('/get-message', [Techsfactory\TfactoryTeamflow\Http\Controllers\SendMessageController::class, 'index'])->name('teamflow.message.index');
    Route::post('/send-message', [Techsfactory\TfactoryTeamflow\Http\Controllers\SendMessageController::class, 'store'])->name('teamflow.message.store');

    Route::post('/attachments/store', [Techsfactory\TfactoryTeamflow\Http\Controllers\AttachmentController::class, 'store'])->name('teamflow.attachment.store');
    Route::get('/attachments/recent', [Techsfactory\TfactoryTeamflow\Http\Controllers\AttachmentController::class, 'getRecentFiles'])->name('teamflow.attachment.recent');
    Route::delete('/attachments/delete/{id}', [Techsfactory\TfactoryTeamflow\Http\Controllers\AttachmentController::class, 'delete'])->name('teamflow.attachment.delete');
});