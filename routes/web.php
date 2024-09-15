<?php

use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

Route::prefix('app')->group(function () {
    Route::get('{path?}', [WebController::class, 'app'])->where('path', '(.*)')->name('app');
});
