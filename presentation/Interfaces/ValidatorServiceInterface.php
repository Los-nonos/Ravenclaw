<?php


namespace Presentation\Interfaces;


interface ValidatorServiceInterface
{
    public function make(array $options, array $rules);

    public function isValid();

    public function getErrors();
}
