<?php

use App\Http\Controllers\CropController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\PointController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', [MapController::class, 'viewMap']);
Route::get('/', [PointController::class, 'index']);
Route::get('/point/json', [PointController::class, 'pointJson']);
Route::get('/point/location/{id}', [PointController::class, 'locationJson']);

// maps thiland
Route::get('/mapThailand', [CropController::class, 'index']);
Route::get('/pointCrop/json', [CropController::class, 'pointCropJson']);
