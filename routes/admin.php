<?php

use Azuriom\Plugin\CreatorsIps\Http\Controllers\Admin\CreatorIpController;
use Azuriom\Plugin\CreatorsIps\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

Route::middleware('can:creatorsips.admin')->group(function () {
    Route::resource('ips', CreatorIpController::class)->parameters(['ips' => 'creatorIp']);

    Route::get('/settings', [SettingController::class, 'show'])->name('settings');
    Route::post('/settings', [SettingController::class, 'save'])->name('settings.save');
    Route::post('/settings/token', [SettingController::class, 'regenerateToken'])->name('settings.token');
});
