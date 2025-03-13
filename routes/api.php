<?php

use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\AssessmentController;
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

//Route::group(
//    ['prefix' => 'admin', 'as' => 'admin.','middleware' => ['auth','admin']],
//    function () {
//        Route::group(
//            ['prefix' => 'courts', 'as' => 'courts.'],
//            function () {
//                Route::controller(CourtController::class)->group(
//                    function () {
//                        Route::get('/', 'index')->name('index');
//                        Route::get('create', 'create')->name('create');
//                        Route::post('/', 'store')->name('store');
//                        Route::get('{id}/edit','edit')->name('edit');
//                        Route::post('{id}', 'update')->name('update');
//                        Route::get('destroy/{id}', 'destroy')->name('destroy');
//                    }
//                );
//            }
//        );

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(
    ['prefix' => 'advertisements'],
    function () {
        Route::controller(AdvertisementController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('show', 'show');
            Route::post('update', 'update');
            Route::post('booking', 'booking');
            Route::post('favorite', 'storeFavoriteAdvertisement');
            Route::post('photos', 'storePhoto');
            Route::post('photos/delete', 'deletePhoto');
        });

    }

);
Route::post('login', [AuthController::class, 'login']);
Route::post('change/password/send/email', [ResetPasswordController::class, 'sendEmail']);
Route::post('change/password', [ResetPasswordController::class, 'changePassword']);
Route::post('change/password/resend/email', [ResetPasswordController::class, 'resendEmail']);
Route::post('register', [AuthController::class, 'register']);
Route::post('verify/phone/code', [AuthController::class, 'verifyPhoneCode']);
Route::post('resend/on/num', [AuthController::class, 'resendOnNum']);
Route::post('continue/register', [AuthController::class, 'continueRegister']);
Route::post('users/update', [UserController::class, 'update']);


Route::post('assessments', [AssessmentController::class, 'store']);//->middleware('auth:sanctum');
Route::post('assessments/update', [AssessmentController::class, 'update']);
Route::post('assessments/examinate', [AssessmentController::class, 'examinate'])
    ->middleware('auth:sanctum')->middleware('admin');
Route::get('filter', [AdvertisementController::class, 'filter']);

Route::get('filter/two', [AdvertisementController::class, 'filterTwo']);
Route::get('reservations', [ReservationController::class, 'index']);
Route::get('reservations/filter', [ReservationController::class, 'filter']);
Route::post('add/photo/user', [UserController::class, 'addPhoto']);
Route::post('delete/photo/user', [UserController::class, 'deletePhoto']);
Route::post('reservation/pass', [ReservationController::class, 'pass']);
