<?php


namespace Application\Services;


use Domain\Entities\Customer;
use Domain\Entities\Order;

use Paypal\Core\PaypalHttpClient;
use Paypal\v1\Payments\PaymentsCreateRequest;
use Paypal\v1\Payments\PaymentExecuteRequest;
use Paypal\Core\SandboxEnviroment;
use Paypal\Core\ProductionEnviroment;

class PaypalService implements PaymentGateway, PaymentGatewayAuthorization
{

    public function execute(Customer $customer, Order $order)
    {
        // TODO: Implement execute() method.
    }

    public function Authorization(Customer $customer, int $amount): Order
    {
        // TODO: Implement Authorization() method.
    }
}
