<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


use App\Http\Controllers\QuinielaController;
use App\Http\Controllers\AdminController;

Route::get('/', [QuinielaController::class, 'showForm'])->name('quiniela.welcome');
Route::get('/quiniela', [QuinielaController::class, 'showForm'])->name('quiniela.form');
Route::post('/quiniela', [QuinielaController::class, 'submitForm'])->name('quiniela.submit');
Route::get('/quiniela/ranking', [QuinielaController::class, 'ranking'])->name('quiniela.ranking');

Route::get('/quiniela/quinielas-capturadas', [QuinielaController::class, 'capturedResults'])->name('quiniela.quinielas-capturadas');


// Rutas para acceso restringido y captura de resultados
Route::get('/admin/access', [AdminController::class, 'showAccessForm'])->name('admin.access');
Route::post('/admin/access', [AdminController::class, 'validateAccess'])->name('admin.validate');
Route::get('/admin/results', [AdminController::class, 'showResultsForm'])->name('admin.results');
Route::post('/admin/results', [AdminController::class, 'submitResults'])->name('admin.results.submit');
Route::get('/admin/activar-quinielas', [AdminController::class, 'activeAllQuinielas'])->name('admin.activar-quinielas');
Route::get('/admin/ver-quinielas', [AdminController::class, 'showAllQuinielas'])->name('admin.ver-quinielas');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/matches', [AdminController::class, 'showMatchForm'])->name('admin.matches');
    Route::post('/admin/matches/create', [AdminController::class, 'createMatch'])->name('admin.matches.create');
    Route::post('/admin/matches/activate', [AdminController::class, 'activatePhaseMatches'])->name('admin.matches.activate');
    Route::post('/admin/matches/deactivate', [AdminController::class, 'deactivatePhaseMatches'])->name('admin.matches.deactivate');
});