<?php


namespace Presentation\Http\Presenters\Auth;


use Infrastructure\QueryBus\Result\ResultInterface;

class LoginPresenter
{
    private ResultInterface $result;

    public function fromResult(ResultInterface $result): LoginPresenter {
        $this->result = $result;
        return $this;
    }

    public function getData(): array {
        return [
            'token' => $this->result,
        ];
    }
}
