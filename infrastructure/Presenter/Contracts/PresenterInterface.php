<?php

declare(strict_types=1);

namespace Infrastructure\Presenter\Contracts;

use Infrastructure\JsonableInterface;

interface PresenterInterface extends JsonableInterface
{
    /**
     * Get data for current use case
     *
     * @return array
     */
    public function getData(): array;
}
