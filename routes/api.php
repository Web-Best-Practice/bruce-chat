<?php

use Illuminate\Support\Facades\Route;
use WebBestPractice\BruceChat\Http\Controllers\CapabilitiesController;
use WebBestPractice\BruceChat\Http\Controllers\ToolController;

Route::get('capabilities', CapabilitiesController::class)->name('capabilities');
Route::post('tools/{tool}', ToolController::class)->name('tools.invoke');
