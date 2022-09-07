<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix("student")->group(function () {
    Route::post('/submit-files', [App\Http\Controllers\Api\Student\UploadController::class, "postUpload"]);
});
Route::prefix("admin-mod")->group(function () {
    Route::get('/get-data', [\App\Http\Controllers\Api\AdminMod\StatisticsController::class, "getData"]);
});
