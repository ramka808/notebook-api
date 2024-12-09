<?php

use App\Models\Notebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotebookController;

Route::get('/notebook', [NotebookController::class , 'index']);
Route::post('/notebook', [NotebookController::class , 'store']);
Route::get('/notebook/{id}', [NotebookController::class , 'show']);//Работает
Route::post('/notebook/{id}', [NotebookController::class , 'update']);//Работает
Route::delete('/notebook/{id}', [NotebookController::class , 'destroy']);//Работает
