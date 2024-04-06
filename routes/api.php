<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiWordController;
use App\Http\Controllers\ApiDepartmentController;
use App\Http\Controllers\ApiUserController;
use App\Http\Controllers\ApiExamController;
use App\Http\Controllers\ApiExamBankController;
use App\Http\Controllers\ApiExamShiftController;

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

//header('Access-Control-Allow-Origin: http://localhost:9091');
//header('Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT');
//header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, Content-Disposition, X-Token');
//header('Access-Control-Allow-Credentials: true');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::post('/login', [ApiUserController::class, 'login']);

Route::post('/word/upload-file', [ApiWordController::class, 'uploadFile']);
Route::post('/word/calculate', [ApiWordController::class, 'calculate']);
Route::get('/departments', [ApiDepartmentController::class, 'get']);
Route::post('/departments', [ApiDepartmentController::class, 'save']);
Route::put('/departments/{id}', [ApiDepartmentController::class, 'update']);
Route::get('/users', [ApiUserController::class, 'get']);
Route::post('/users', [ApiUserController::class, 'save']);
Route::put('/users/{id}', [ApiUserController::class, 'update']);
Route::get('/exams', [ApiExamController::class, 'get']);
Route::post('/exams', [ApiExamController::class, 'save']);
Route::post('/exams/getExamShifts', [ApiExamController::class, 'getExamShifts']);
Route::get('/exam-banks', [ApiExamBankController::class, 'get']);
Route::post('/exam-banks', [ApiExamBankController::class, 'save']);
Route::put('/exam-banks/{id}', [ApiExamBankController::class, 'update']);
Route::get('/exam-banks/settings', [ApiExamBankController::class, 'getSettings']);
Route::post('/exam-shifts/checkCodeExits', [ApiExamShiftController::class, 'checkExamShiftCodeExits']);
