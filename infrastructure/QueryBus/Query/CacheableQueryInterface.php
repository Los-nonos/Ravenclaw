<?php
declare(strict_types=1);

namespace Infrastructure\QueryBus\Query;

interface CacheableQueryInterface extends QueryInterface
{
    public function getCacheKey(): string;
    public function getTTL(): int;
}
