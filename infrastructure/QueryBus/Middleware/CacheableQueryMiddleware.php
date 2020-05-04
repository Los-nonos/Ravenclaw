<?php
declare(strict_types=1);

namespace Infrastructure\QueryBus\Middleware;

use Infrastructure\QueryBus\Exception\InvalidQueryException;
use Infrastructure\QueryBus\Query\CacheableQueryInterface;
use Infrastructure\QueryBus\Query\QueryInterface;
use League\Tactician\Middleware;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

final class CacheableQueryMiddleware implements Middleware
{
    private CacheItemPoolInterface $cacheItemPool;

    public function __construct(CacheItemPoolInterface $cacheItemPool)
    {
        $this->cacheItemPool = $cacheItemPool;
    }

    /**
     * @param object $query
     * @param callable $next
     * @return mixed
     * @throws InvalidQueryException
     * @throws InvalidArgumentException
     */
    public function execute($query, callable $next)
    {
        if (! $query instanceof QueryInterface) {
            throw new InvalidQueryException(
                'The query parameter must be an instance of QueryInterface'
            );
        }

        if (! $query instanceof CacheableQueryInterface) {
            return $next($query);
        }

        $cachedResult = $this->cacheItemPool->getItem($query->getCacheKey());

        if ($cachedResult->isHit()) {
            return $cachedResult->get();
        }

        $cachedResult
            ->set($next($query))
            ->expiresAfter($query->getTTL());

        $this->cacheItemPool->save($cachedResult);

        return $cachedResult->get();
    }
}
