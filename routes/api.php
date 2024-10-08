<?php

use App\Http\Controllers\ArtifactController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\IssueTokenAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/auth', IssueTokenAction::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn (Request $request) => $request->user());
    Route::resource('artifacts', ArtifactController::class);
    Route::resource('catalogs', CatalogController::class);
    Route::resource('assets', AssetController::class);
});
