<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/', [ContactController::class, 'index'])->name('contacts.index');
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
Route::get('/contacts/{id}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
Route::post('/contacts/{id}', [ContactController::class, 'update'])->name('contacts.update');
Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');
