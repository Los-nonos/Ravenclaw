<?php


namespace Presentation\Interfaces\Users;


use Application\Results\Users\UpdateUserResultInterface;
use Presentation\Http\Presenters\Users\UpdateUserPresenter;

interface UpdateUserPresenterInterface
{
    public function fromResult(UpdateUserResultInterface $result): UpdateUserPresenter;
    public function getData(): array;
}
