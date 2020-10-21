<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Presentation\Http\Actions;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function() {
    Route::post('/login', Actions\Auth\LoginAction::class)->name('login');
});

Route::middleware('role.auth:admin,customer')->prefix('users')->group(function() {
    Route::put('/:id', Actions\Users\UpdateUserAction::class)->name('updateUser');
});

Route::middleware('role.auth:admin')->prefix('admins')->group(function() {
    Route::post('/', Actions\Admins\CreateAdminAction::class)->name('createAdmin');

    Route::get('/', Actions\Admins\ShowAdminByIdAction::class)->name('findAdmin');
});

Route::middleware('role.auth:admin')->prefix('customers')->group(function() {
    Route::get('/one',  Actions\Customers\ShowCustomerByIdAction::class)->name('showCustomerById');

    Route::get('/', Actions\Customers\IndexCustomerAction::class)->name('indexCustomers');

    Route::post('/', Actions\Customers\CreateCustomerAction::class)->name('createCustomer');

    Route::delete('/:id', Actions\Customers\DestroyCustomerByIdAction::class)->name('destroyCustomer');
});

Route::middleware('role.auth:customer')->prefix('payments')->group(function () {

  Route::post('/process', Actions\Payments\ProcessPaymentAction::class)->name('process-payments');

  Route::post('/authorize', Actions\Payments\AuthorizePaymentsAction::class)->name('authorize-payments');

  Route::post('/afip/electronic-billing', Actions\Payments\AfipElectronicBillingAction::class)->name('afip-electronicBilling');
});
