<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiWordController;
use App\Http\Controllers\ApiDepartmentController;

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

header('Access-Control-Allow-Origin: http://localhost:9091');
header('Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, Content-Disposition');
header('Access-Control-Allow-Credentials: true');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users', [ApiWordController::class, 'index']);
Route::post('/word/upload-file', [ApiWordController::class, 'uploadFile']);
Route::post('/word/calculate', [ApiWordController::class, 'calculate']);
Route::get('/department', [ApiDepartmentController::class, 'get']);
Route::post('/department', [ApiDepartmentController::class, 'save']);
Route::put('/department/{id}', [ApiDepartmentController::class, 'update']);
