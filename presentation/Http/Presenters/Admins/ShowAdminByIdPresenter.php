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
        $admin = $this->result->getAdmin();
        return [
            'admin' => $admin->__serialize(),
            'message' => 'Show admin has been successfully'
        ];
    }
}
