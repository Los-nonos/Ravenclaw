<?php


namespace Presentation\Http\Presenters\Auth;


class RenewTokenPresenter
{
    private $result;

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
