<?php


namespace Presentation\Http\Presenters\Customers;


class CreateCustomerPresenter
{
    public function getData(): array
    {

        return [
            'message' => 'Customer has been created successfully'
        ];
    }
}
