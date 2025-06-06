<?php


use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Cart\CartController;
use App\Http\Controllers\Api\Lead\LeadController;
use App\Http\Controllers\Api\Agent\AgentController;
use App\Http\Controllers\Api\Order\OrderController;
use App\Http\Controllers\Api\Product\ProductController;
use App\Http\Controllers\Api\Service\ServiceController;
use App\Http\Controllers\Api\Customer\CustomerController;
use App\Http\Controllers\Api\Payment\StripePaymentController;
use App\Http\Controllers\Api\Webhook\StripeWebhookController;

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
//=================================================> Auth Routes<===================================================
Route::controller(AuthController::class)->group(function () {   
Route::post('/agent/register','agentRegister');
Route::post('/customer/register','customerRegister');
Route::post('/change/password','changePassword')->middleware(['api.auth']);
Route::post('/forgot/password','forgotPassword');
Route::post('/reset/password','resetPassword');
Route::post('/login','login');
Route::post('/logout','logout')->middleware(['api.auth']);
});
Route::post('/email/verify',[AuthController::class,'verifyEmail'])
->middleware(['auth:sanctum','throttle:6,1'])->name('verification.verify');

//=================================================> Lead Routes<===================================================
Route::resource('lead',LeadController::class)->middleware(['auth:sanctum','role.agent','api.verified']);
//=================================================> Service Routes<===================================================
Route::resource('service',ServiceController::class)->middleware(['auth:sanctum','api.verified']);
//=================================================> Product Routes<===================================================
Route::resource('product',ProductController::class)->middleware(['auth:sanctum','api.verified']);
//=================================================> Agent Routes<===================================================
Route::middleware(['auth:sacntum','api.verified'])->prefix('/agent')->group(function () {
Route::get('/fetch/customers',[AgentController::class,'index']);
});
Route::controller(CustomerController::class)->middleware(['auth:sanctum','role.agent','api.verified'])->group(function () {
    Route::post('/fetch/cart/by-user','fetchCart'); 
 });



//=================================================>Add to Cart Routes<===================================================
Route::controller(CartController::class)->middleware(['auth:sanctum','api.verified'])->group(function () {
   Route::post('/add/to/cart','addToCart'); 
});


//=================================================>Order Routes <===================================================
Route::controller(OrderController::class)->middleware(['auth:sanctum','api.verified'])->group(function(){

  Route::post('/customer/checkout/{cart}','checkout');  
                                      //==========================>All Order fetch<=====================//

  Route::get('/customer/orders','index');
});

//==================================================Stripe Payment Routes<===================================================
Route::controller(StripePaymentController::class)->middleware(['auth:sanctum','api.verified'])->group(function () {
    Route::get('stripe', 'stripe');
    Route::get('stripe/{order}', 'checkout')->name('stripe.post');
});


//===============================================================> Mark order as paid<======================================
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);