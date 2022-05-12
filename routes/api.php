<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/v1')->group(__DIR__ . '/api-version/version-1.php');
