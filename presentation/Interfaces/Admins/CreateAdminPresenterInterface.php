<?php


namespace Presentation\Interfaces\Admins;


use Application\Results\Admins\CreateAdminResultInterface;

interface CreateAdminPresenterInterface
{
    public function fromResult(CreateAdminResultInterface $result): CreateAdminPresenterInterface;
    public function getData(): array;
}
