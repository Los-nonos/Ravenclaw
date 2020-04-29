<?php


namespace Presentation\Http\Presenters\Admins;


use Application\Queries\Results\Admins\ShowAdminByIdResult;

class ShowAdminByIdPresenter
{
    private ShowAdminByIdResult $result;

    public function fromResult(ShowAdminByIdResult $result): ShowAdminByIdPresenter
    {
        $this->result = $result;
        return $this;
    }

    public function getData(): array {
        return [
            'admin' => $this->result->getAdmin(),
            'message' => 'Show admin has been successfully'
        ];
    }
}
