<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinkController;

Route::get('/{slug}', [LinkController::class, 'handleRedirect'])->name('link.redirect');
