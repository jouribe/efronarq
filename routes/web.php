<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PullApartController;
use App\Http\Controllers\VisitController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->resource('banks', BankController::class);
Route::middleware(['auth:sanctum', 'verified'])->resource('projects', ProjectController::class);
Route::middleware(['auth:sanctum', 'verified'])->resource('visits', VisitController::class);
Route::middleware(['auth:sanctum', 'verified'])->get('/visits/{id}/quote/generate', [VisitController::class, 'generate'])->name('visits.quote');
Route::middleware(['auth:sanctum', 'verified'])->resource('pull-apart', PullApartController::class);
Route::middleware(['auth:sanctum', 'verified'])->get('/pull-apart/{id}/agreement/generate', [PullApartController::class, 'generate'])->name('pull-apart.agreement');
