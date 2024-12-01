<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\QuinielaController;
use App\Http\Controllers\AdminController;

Route::get('/quiniela', [QuinielaController::class, 'showForm'])->name('quiniela.form');
Route::post('/quiniela', [QuinielaController::class, 'submitForm'])->name('quiniela.submit');
Route::get('/quiniela/ranking', [QuinielaController::class, 'ranking'])->name('quiniela.ranking');

Route::get('/quiniela/quinielas-capturadas', [QuinielaController::class, 'capturedResults'])->name('quiniela.quinielas-capturadas');


// Rutas para acceso restringido y captura de resultados
Route::get('/admin/access', [AdminController::class, 'showAccessForm'])->name('admin.access');
Route::post('/admin/access', [AdminController::class, 'validateAccess'])->name('admin.validate');
Route::get('/admin/results', [AdminController::class, 'showResultsForm'])->name('admin.results');
Route::post('/admin/results', [AdminController::class, 'submitResults'])->name('admin.results.submit');