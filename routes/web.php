<?php

use App\Http\Controllers\CardiacController;
use App\Http\Controllers\CardiacItemController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('cardiac/liste', [CardiacController::class, 'list'])
    ->name('cardiac.liste');

Route::get('cardiac/getAll', [CardiacController::class, 'getAll'])
    ->name('cardiac.getAll');

Route::get('cardiac/formulaire', [CardiacController::class, 'form'])
    ->name('cardiac.form');

Route::get('cardiac/formulaireEtape', [CardiacItemController::class, 'form'])
    ->name('cardiac.formSteps');

Route::get('cardiac/Exercice/{id}', [CardiacController::class, 'exercice'])
    ->name('cardiac.exercice');

Route::get('cardiac/getLinkCardiacItem/{id}', [CardiacController::class, 'getLinkItem'])
    ->name('getLinkCardiacItem');

Route::get('cardiac/getLast', [CardiacController::class, 'getLast'])
    ->name('getLast');

Route::post('cardiac/createItem', [CardiacItemController::class, 'create'])
    ->name('cardiac.createItem');

Route::post('cardiac/create', [CardiacController::class, 'create'])
    ->name('cardiac.create');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
