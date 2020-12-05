<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->resource('banks', BankController::class);
Route::middleware(['auth:sanctum', 'verified'])->resource('projects', ProjectController::class);
