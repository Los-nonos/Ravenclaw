<?php


namespace Presentation\Http\Presenters\Auth;


use Application\Queries\Results\Auth\RenewTokenResult;

class RenewTokenPresenter
{
    private RenewTokenResult $result;

    public function fromResult($result): RenewTokenPresenter
    {
        $this->result = $result;
        return $this;
    }

    public function getData(): array
    {
        return [
            'token' => $this->result->getToken(),
        ];
    }
}
