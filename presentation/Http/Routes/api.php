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

Route::group(['prefix' => 'users'], function() {
    Route::put('/:id', Actions\Users\UpdateUserAction::class)->name('updateUser');
});

Route::group(['prefix' => 'admins'], function() {
    Route::post('/', Actions\Admins\CreateAdminAction::class)->name('createAdmin');

    Route::get('/', Actions\Admins\ShowAdminByIdAction::class)->name('findAdmin');
});

Route::group(['prefix' => 'customers'], function() {
    Route::get('/one',  Actions\Customers\ShowCustomerByIdAction::class)->name('showCustomerById');

    Route::get('/', Actions\Customers\IndexCustomerAction::class)->name('indexCustomers');

    Route::post('/', Actions\Customers\CreateCustomerAction::class)->name('createCustomer');

    Route::delete('/:id', Actions\Customers\DestroyCustomerByIdAction::class)->name('destroyCustomer');
});

Route::group(['prefix' => 'payments'], function () {
    Route::post('/paypal/authorization', Actions\Payments\PaypalAuthorizationAction::class)->name('paypalAuthorization');

    Route::post('/paypal/pay', Actions\Payments\PaypalExecuteAction::class)->name('paypalPay');

    Route::post('/mercadopago/pay', Actions\Payments\MercadoPagoExecuteAction::class)->name('mercadoPagoPay');
});
