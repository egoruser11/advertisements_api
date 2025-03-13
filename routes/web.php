<?php

use App\Jobs\AssessmentRecalculated;
use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use  App\Mail\AssessmentOwner;

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

Route::get('/', function () {
    $user = User::first();
    $advertisement = Advertisement::first();
    //AssessmentRecalculated::dispatch($advertisement->id);
//    Mail::to($user)->send(new AssessmentOwner($advertisement, $user));


//    $var1 = function ($num1) {
//        return $num1 * $num1;
//    };
//    $var2 = 10;
//    return $var1($var2);
    $a = 1;
});
