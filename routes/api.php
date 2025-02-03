<?php

use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login',[AuthController::class, 'login']);
Route::post('change/password/send/email',[ResetPasswordController::class, 'sendEmail']);
Route::post('change/password',[ResetPasswordController::class, 'changePassword']);
Route::post('change/password/resend/email',[ResetPasswordController::class, 'resendEmail']);
Route::post('register',[AuthController::class, 'register']);
Route::post('verify/phone/code',[AuthController::class, 'verifyPhoneCode']);
Route::post('resend/on/num',[AuthController::class, 'resendOnNum']);
Route::post('continue/register',[AuthController::class, 'continueRegister']);
Route::post('users/update',[UserController::class, 'update']);
Route::get('advertisements',[AdvertisementController::class, 'index']);
Route::post('advertisements',[AdvertisementController::class, 'store']);
Route::post('advertisements/update',[AdvertisementController::class, 'update']);
Route::get('advertisement',[AdvertisementController::class, 'show']);
Route::post('booking',[AdvertisementController::class, 'booking']);
Route::post('add/favorite/advertisement',[AdvertisementController::class, 'addFavoriteAdvertisement']);
Route::post('add/assessment',[AdvertisementController::class, 'addAssessment']);//->middleware('auth:sanctum');
Route::post('add/review/to/assessment',[AdvertisementController::class, 'updateReview']);
Route::post('examination/assessment',[AdvertisementController::class, 'examinationAssessment'])
    ->middleware('auth:sanctum')->middleware('admin');
Route::get('filter',[AdvertisementController::class, 'filter']);
Route::post('add/photos/advertisement',[AdvertisementController::class, 'addPhoto']);
Route::post('delete/photos/advertisement',[AdvertisementController::class, 'deletePhoto']);
Route::get('filter/two',[AdvertisementController::class, 'filterTwo']);
Route::get('reservations',[ReservationController::class, 'index']);
Route::get('reservations/filter',[ReservationController::class, 'filter']);
Route::post('add/photo/user',[UserController::class, 'addPhoto']);
Route::post('delete/photo/user',[UserController::class, 'deletePhoto']);
Route::post('reservation/pass',[ReservationController::class, 'pass']);
