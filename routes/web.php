<?php

use App\Http\Controllers\ApplicantionController;
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
Route::get('applicant/review', [ApplicantionController::class, 'applicantReview'])->name('applicant.review');
Route::post('store/schengen/details', [ApplicantionController::class,'storeSchengenDetails'])->name('store.schengen.details');

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

Route::get('/product/{id}',[HomeController::class,'product']);

Route::get('append_signature/{id}',[HomeController::class,'signature'])->name('signature');
Route::get('signature_success/{id}',[HomeController::class,'signature_success'])->name('signature_success');
Route::get('/referal_details/{id}',[HomeController::class,'referal'])->name('referal');

Route::post('/upload_signature', [HomeController::class,'upload']);
Route::post('/add_referal', [HomeController::class,'addreferal']);

Route::get('/myapplication',[HomeController::class,'myapplication']);
Route::get('/affiliate', [HomeController::class,'affiliate'])->name('affiliate');

Route::post('/add-referrer', [HomeController::class,'addReferrer'])->name('add-referer');

// Reset Password

Route::post('reset/password', [ResetPasswordController::class,'updatePassword'])->name('customize.password.update');
Route::post('reset/forgot/password', [ResetPasswordController::class,'forgotPassword'])->name('customize.forgot.password');

// Route::get('payment-form/{id}', [HomeController::class,'payment'])->name('payment');

Route::get('payment_form/{id}',[HomeController::class,'payment'])->name('payment');

Route::post('/add_payment', [HomeController::class,'addpayment']);

// Applicant
Route::get('applicant/details', [ApplicantionController::class, 'applicantDetails'])->name('applicant.details');
Route::get('applicant/{id}', [ApplicantionController::class,'applicanview'])->name('applicant');
Route::post('store/applicant', [ApplicantionController::class,'storeApplicant'])->name('store.applicant');
Route::post('srore/applicant/details', [ApplicantionController::class,'storeApplicantDetails'])->name('store.applicant.details');
Route::post('store/home/country/details', [ApplicantionController::class,'storeHomeCountryDetails'])->name('store.home-country.details');
Route::post('store/current/details', [ApplicantionController::class,'storeCurrentDetails'])->name('store.current.details');
Route::post('upload/passport/copy', [ApplicantionController::class, 'uploadPassportCopy'])->name('upload.passport.copy');
Route::post('/add/experience', [ApplicantionController::class,'addExperience'])->name('add.experience');
