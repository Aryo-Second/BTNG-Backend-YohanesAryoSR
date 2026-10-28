<?php

use App\Http\Controllers\GundamController;
use Illuminate\Support\Facades\Route;

Route::apiResource('gundam', GundamController::class);