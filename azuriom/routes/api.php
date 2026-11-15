<?php

use Azuriom\Plugin\CreatorsIps\Http\Controllers\Api\JoinController;
use Illuminate\Support\Facades\Route;

Route::post('/join', JoinController::class)->name('join');
