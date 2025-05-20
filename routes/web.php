<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomFieldController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/', [ContactController::class, 'index'])->name('contacts.index');
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
Route::get('/contacts/{id}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
Route::put('/contacts/{id}', [ContactController::class, 'update'])->name('contacts.update');
Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');
Route::get('/contacts/table', [ContactController::class, 'table'])->name('contacts.table');


Route::get('/custom-fields', [CustomFieldController::class, 'index'])->name('custom-fields.index');
Route::post('/custom-fields', [CustomFieldController::class, 'store'])->name('custom-fields.store');