<?php

use App\Http\Controllers\Api\V1\MataKuliahController;
use App\Http\Controllers\Api\V1\ProgramStudiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('v1.')->group(function () {

    // Mengambil daftar program studi.
    Route::get('program-studi',[ProgramStudiController::class, 'index'])->name('program-studi.index');

    // CRUD mata kuliah.
    Route::apiResource('mata-kuliah',MataKuliahController::class);
    Route::post('mata-kuliah', [MataKuliahController::class, 'store']);
}); 