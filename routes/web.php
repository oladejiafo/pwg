<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Affiliate\AffiliatePartnerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Laravel\Jetstream\Rules\Role;

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


Route::get('/resend/verification/{user}',[HomeController::class, 'resendVerificationEmail'])->name('resend.verification');
Route::get('payment/success',[HomeController::class,'paymentSuccess'])->name('payment-success');
Route::get('payment/fail',[HomeController::class,'paymentFail'])->name('payment-fail');
Route::get('/get/receipt/{ptype}',[HomeController::class, 'getReceipt'])->name('getReceipt');
Route::get('/get/invoice/{ptype?}',[HomeController::class, 'getInvoice'])->name('getInvoice');

// Route::get('/get/invoice/{ptype}',[HomeController::class, 'getInvoice'])->name('getInvoice');

Route::post('/upload_signature', [HomeController::class,'upload'])->name('upload');

Route::post('store/applicant/details', [ApplicationController::class,'storeApplicantDetails'])->name('store.applicant.details');
Route::post('get-promo',[HomeController::class, 'getPromo'])->name('getPromo');
Route::post('check-promo',[HomeController::class, 'checkPromo'])->name('checkPromo');
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

Route::get('/home', [HomeController::class, 'redirect'] )->middleware(['auth', 'verified'])->name('redirect');

// Route::get('/signup', [HomeController::class, 'signup'] );

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::post('/product',[HomeController::class,'product'])->name('product');
Route::get('/package/type/{id}',[HomeController::class,'packageType'])->name('packageType');

Route::post('set_session', [HomeController::class, 'createsession'])->name('createsession');

Route::get('append_signature/{id}',[HomeController::class,'signature'])->name('signature');
Route::get('signature_success/{id}',[HomeController::class,'signature_success'])->name('signature_success');
Route::get('/referal_details/{id}',[HomeController::class,'referal'])->name('referal');

Route::post('/add_referal', [HomeController::class,'addreferal']);

Route::get('/myapplication',[HomeController::class,'myapplication'])->name('myapplication');
Route::get('/affiliate', [HomeController::class,'affiliate'])->name('affiliate');

Route::post('/add-referrer', [HomeController::class,'addReferrer'])->name('add-referer');
Route::put('family/details/submit', [HomeController::class, 'familyDetails'])->name('family.details.submit');
Route::get('contract/{id}', [HomeController::class, 'contract'])->name('contract');
Route::get('contract/view/{id}', [HomeController::class, 'contractReview'])->name('contract-review');

// Reset Password
Route::post('reset/password', [ResetPasswordController::class,'updatePassword'])->name('customize.password.update');
Route::post('reset/forgot/password', [ResetPasswordController::class,'forgotPassword'])->name('customize.forgot.password');
Route::post('update/password', [ResetPasswordController::class, 'updateCurrentPassword'])->name('update.current.password');

//Payments
Route::get('payment_form/{id}',[HomeController::class,'payment'])->name('payment');
Route::post('/add_payment', [HomeController::class,'addpayment']);

// Applicant
Route::post('/add/experience', [ApplicationController::class,'addExperience'])->name('add.experience');
Route::get('applicant/details/{id}', [ApplicationController::class, 'applicantDetails'])->name('applicant.details');
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
Route::post('update/applicant/status', [ApplicationController::class, 'updateApplicantStatus'])->name('update.applicant.status');
Route::post('check/applicant/status', [ApplicationController::class, 'checkApplicationStatus'])->name('check.applicant.status');

//Dependent
Route::post('store/dependent/details', [ApplicationController::class, 'storeDependentDetails'])->name('store.dependent.details');
Route::post('store/spouse/home/country/details', [ApplicationController::class, 'storeDependentHomeContryDetails'])->name('store.spouse.home.country.details');
Route::post('store/spouse/current/details', [ApplicationController::class, 'storeSpouseCurrentDetails'])->name('store.spouse.current.details');
Route::post('store/spouse/schengen/details', [ApplicationController::class, 'storeSpouseSchenegenDetails'])->name('store.spouse.schengen.details');
Route::post('/get/dependent/selected/experience', [ApplicationController::class,'getDependentExperience'])->name('get.dependent.selected.experience');

//children
Route::post('store/children/details', [ApplicationController::class, 'storeChildrenDetails'])->name('store.children.details');

//notifications
// Route::get('user/notifications', [HomeController::class, 'notifications'])->name('notifications');

Route::post('card_details', [HomeController::class, 'card_details'])->name('card_details');
Route::post('mark_read', [HomeController::class, 'mark_read'])->name('mark_read');

//experience
Route::post('/get/job/category/list', [ApplicationController::class, 'getJobCategories']);
Route::post('/get/job/category/four/list', [ApplicationController::class, 'getJobCategoryFourList']);

//Quickbook
Route::get('quickbook/token', [HomeController::class, 'getQuickbookToken']);
Route::get('refresh/token', [HomeController::class, 'refreshToken']);
Route::get('disconnect/quickbook', [HomeController::class, 'disconnectQuickbook']);

//Terms
Route::get('/terms',[HomeController::class, 'terms'])->name('terms');

// Affiliate

Route::group(['namespace' => 'Affiliate', 'prefix' => '/affiliate','as' => 'affiliate.',
  ], function () {
        Route::get('/', [AffiliatePartnerController::class, 'index'])->name('home');

        Route::get('dashboard',[AffiliatePartnerController::class,'dashboard'])->middleware('isLoggedIn');

        //Authentications 
        Route::post('affiliate-login', [AffiliatePartnerController::class,'affiliate_login'])->name('affiliate-login');
        Route::get('affiliateLogin', [AffiliatePartnerController::class,'affiliateLogin'])->name('login'); //->middleware('alreadyLoggedIn')
        Route::get('affiliateLogout', [AffiliatePartnerController::class,'affiliateLogout'])->name('logout');

        Route::get('forgot-password', [AffiliatePartnerController::class,'forgotPassword'])->name('forgot-password');
        Route::post('PasswordRequest',[AffiliatePartnerController::class,'PasswordRequest'])->name('PasswordRequest');
        Route::get('reset-password', [AffiliatePartnerController::class,'resetPassword'])->name('reset-password');
        Route::post('passwordUpdate',[AffiliatePartnerController::class, 'passwordUpdate'])->name('passwordUpdate');
        //New Registration
        Route::post('affiliate-register', [AffiliatePartnerController::class,'affiliate_register'])->name('affiliate-register');
        Route::get('affiliateRegister', [AffiliatePartnerController::class,'affiliateRegister'])->name('register');
  
        //referral
        Route::get('reffered-client/{id}', [AffiliatePartnerController::class,'reffered_client'])->name('reffered_client');
        Route::get('total_earned/{id}', [AffiliatePartnerController::class, 'total_earned'])->name('total_earned');
        //Transfer
        Route::get('transfer/{id}', [AffiliatePartnerController::class,'transfer'])->name('transfer');
        Route::post('process_transfer', [AffiliatePartnerController::class,'process_transfer'])->name('process_transfer');

        Route::get('news', [AffiliatePartnerController::class, 'news'])->name('news');
        Route::get('news/{id}', [AffiliatePartnerController::class, 'newsBrief'])->name('news.brief');
        Route::get('about-us', [AffiliatePartnerController::class, 'aboutUs'])->name('about');
        Route::get('toolbox', [AffiliatePartnerController::class, 'toolBox'])->name('toolbox');
        Route::post('toolbox/loadmore', [AffiliatePartnerController::class, 'toolBoLoadxMore'])->name('loadmore.load_data');

        

});