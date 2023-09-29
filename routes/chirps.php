<?php

use App\Http\Controllers\ChirpController;
use Illuminate\Support\Facades\Route;

/* ============================================================================================
CHIRPS
======================================================================================== */
Route::get('chirps', [ChirpController::class, "index"])->name("chirps.index"); //ics seud -- isc sude
Route::post('chirps', [ChirpController::class, "store"])->name("chirps.store");
Route::get('chirps/create', [ChirpController::class, "create"])->name("chirps.create");
Route::get('chirps/{chirp}', [ChirpController::class, "show"])->name("chirps.show");
Route::put('chirps/{chirp}', [ChirpController::class, "update"])->name("chirps.update");
Route::delete('chirps/{chirp}', [ChirpController::class, "destroy"])->name("chirps.destroy");
Route::get('chirps/{chirp}/edit', [ChirpController::class, "edit"])->name("chirps.edit");