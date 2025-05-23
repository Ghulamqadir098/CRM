<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Lead\LeadController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Service\ServiceController;

Route::get('/', function () {
    return view('index');
})->name('dashboardweb')->middleware('auth','verified');

Route::view('/login','pages.auth.login')->name('login');
Route::view('/register','pages.auth.register')->name('register');
Route::view('fetch/customer','pages.agent.fetch_user')->name('fetch.customer');


// User routes 
Route::controller(UserController::class)->middleware('auth')->group(function () {
Route::get('/all/users','index')->name('all.users');
Route::get('/agents','agentIndex')->name('agent.index');
Route::get('/customers','customerIndex')->name('customer.index');   
});
// Auth routes 
Route::controller(AuthController::class)->group(function () {
    Route::get('agent/register','agentForm')->name('agent.register');
    Route::post('agent/register','agentRegister')->name('agent.form.post');
    Route::post('verify/email','verifyEmail')->name('email.verify');

// Admin routes to create Agents and Customers 
Route::get('admin/agent/register','adminAgentForm')->name('admin.agent.register');
Route::get('admin/customer/register','adminCustomerForm')->name('admin.customer.register');
Route::get('admin/agent/edit/{agent}','adminAgentEdit')->name('admin.agent.edit');
Route::post('admin/agent/edit/{agent}','adminAgentUpdate')->name('admin.agent.update');
Route::get('admin/customer/edit/{customer}','adminCustomerEdit')->name('admin.customer.edit');
Route::post('admin/customer/edit/{customer}','adminCustomerUpdate')->name('admin.customer.update');
Route::get('edit/profile','editProfile')->name('edit.profile');
Route::post('update/profile','updateProfile')->name('update.profile');
Route::post('update/password','updatePassword')->name('update.password');

    // Customer Routes 
    Route::get('customer/register','customerForm')->name('customer.register');
    Route::post('customer/register','customerRegister')->name('customer.form.post');

    Route::post('/login','login')->name('login.post');
    Route::get('/logout','logout')->name('logoutweb')->middleware('auth');
    Route::post('user/delete/{user}','deleteUser')->name('user.delete');
});


// Lead Routes 
Route::resource('leadweb',LeadController::class)->middleware('auth');


// product controller 
Route::resource('productweb',ProductController::class)->middleware('auth');

// Sercive routes
Route::resource('serviceweb',ServiceController::class)->middleware('auth');


// Agent Routes
Route::get('agent/view/{agent}',[UserController::class,'agentView'])->name('agent.view')->middleware('auth'); 

// Customer Routes
Route::get('customer/view/{customer}',[UserController::class,'customerView'])->name('customer.view')->middleware('auth');

// Roles
Route::resource('roles',RoleController::class)->middleware('auth');
