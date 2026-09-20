<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Pagelyne\Media\Http\Controllers\MediaController;

Route::prefix(config('media.routes.prefix', 'media'))
    // ->middleware(config('media.routes.middleware', ['web', 'auth']))
    ->name('media.')
    ->group(function () {

        Route::get('/', [MediaController::class, 'index'])
            ->name('index');

        Route::get('/create', [MediaController::class, 'create'])
            ->name('create');

        Route::post('/', [MediaController::class, 'store'])
            ->name('store');

        Route::get('/{media}', [MediaController::class, 'show'])
            ->name('show');

        Route::put('/{media}', [MediaController::class, 'update'])
            ->name('update');

        Route::delete('/{media}', [MediaController::class, 'destroy'])
            ->name('destroy');

    });