<?php

use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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

Route::post('store/applicant/details', [ApplicationController::class,'storeApplicantDetails'])->name('store.applicant.details');
Route::post('get-promo',[HomeController::class, 'getPromo'])->name('getPromo');
Route::get('applicant/review/{id}', [ApplicationController::class, 'applicantReview'])->name('applicant.review');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
}); 

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[HomeController::class, 'index']);

Route::get('/home', [HomeController::class, 'redirect'] );

// Route::get('/signup', [HomeController::class, 'signup'] );

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/product/{id}',[HomeController::class,'product'])->name('product');
Route::get('append_signature/{id}',[HomeController::class,'signature'])->name('signature');
Route::get('signature_success/{id}',[HomeController::class,'signature_success'])->name('signature_success');
Route::get('/referal_details/{id}',[HomeController::class,'referal'])->name('referal');

Route::post('/upload_signature', [HomeController::class,'upload']);
Route::post('/add_referal', [HomeController::class,'addreferal']);

Route::get('/myapplication',[HomeController::class,'myapplication']);
Route::get('/affiliate', [HomeController::class,'affiliate'])->name('affiliate');

Route::post('/add-referrer', [HomeController::class,'addReferrer'])->name('add-referer');
Route::put('family/details/submit', [HomeController::class, 'familyDetails'])->name('family.details.submit');
Route::get('package/type/{id}', [HomeController::class,'packageType'])->name('package-type');
Route::get('contract/{id}', [HomeController::class, 'contract'])->name('contract');
Route::get('contract/view/{id}', [HomeController::class, 'contractReview'])->name('contract-review');
// Reset Password

Route::post('reset/password', [ResetPasswordController::class,'updatePassword'])->name('customize.password.update');
Route::post('reset/forgot/password', [ResetPasswordController::class,'forgotPassword'])->name('customize.forgot.password');

// Route::get('payment-form/{id}', [HomeController::class,'payment'])->name('payment');

Route::get('payment_form/{id}',[HomeController::class,'payment'])->name('payment');

Route::post('/add_payment', [HomeController::class,'addpayment']);

// Applicant
Route::post('/add/experience', [ApplicationController::class,'addExperience'])->name('add.experience');
Route::get('applicant/details', [ApplicationController::class, 'applicantDetails'])->name('applicant.details');
Route::get('applicant/{id}', [ApplicationController::class,'applicant'])->name('applicant');
Route::post('store/applicant', [ApplicationController::class,'storeApplicant'])->name('store.applicant');
Route::post('store/home/country/details', [ApplicationController::class,'storeHomeCountryDetails'])->name('store.home-country.details');
Route::post('store/current/details', [ApplicationController::class,'storeCurrentDetails'])->name('store.current.details');
Route::post('upload/passport/copy', [ApplicationController::class, 'uploadPassportCopy'])->name('upload.passport.copy');
Route::post('store/schengen/details', [ApplicationController::class,'storeSchengenDetails'])->name('store.schengen.details');
Route::post('/get/selected/experience', [ApplicationController::class,'getApplicantExperience'])->name('get.selected.experience');
Route::post('/remove/selected/experience', [ApplicationController::class,'removeExperience'])->name('remove.selected.experience');
Route::post('/submit/applicant/review/', [ApplicationController::class, 'applicantReviewSubmit'])->name('submit.applicant.review');
Route::post('/submit/applicant/Details/', [ApplicationController::class, 'submitApplicantDetails'])->name('submit.applicant.details');

