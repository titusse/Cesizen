<?php

use App\Http\Controllers\CardiacController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('cardiac')->group(function () {
    Route::get('liste', [CardiacController::class, 'liste'])
        ->name('liste');
});

