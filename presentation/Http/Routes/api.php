<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Presentation\Http\Actions\Customers\ShowCustomerByIdAction;

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

Route::post('/customers', 'Customers\CreateCustomerAction@execute')->name('createCustomer');

Route::put('/users', 'Users\UpdateUserAction@execute')->name('updateUser');

Route::get('/customers', 'Customers\IndexCustomerAction@execute')->name('indexCustomers');

Route::get('/customers/:id', ShowCustomerByIdAction::class)->name('showCustomerById');

Route::post('/admins', 'Admins\CreateAdminAction@execute')->name('createAdmin');

Route::group(['prefix' => 'payments'], function () {
    Route::post('/paypal/authorization', 'Payments\PaypalAuthorizationAction@execute')->name('paypalAuthorization');

    Route::post('/paypal/pay', 'Payments\PaypalExecuteAction@execute')->name('paypalPay');

    Route::post('/mercadopago/pay', 'Payments\MercadoPagoExecuteAction@execute')->name('mercadoPagoPay');
});
