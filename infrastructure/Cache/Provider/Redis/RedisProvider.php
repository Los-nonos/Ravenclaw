<?php
declare(strict_types=1);

namespace Infrastructure\Cache\Provider\Redis;

use DateInterval;
use Infrastructure\Cache\CacheItem;
use Infrastructure\Cache\Exception\InvalidArgumentException;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Redis;

final class RedisProvider implements CacheItemPoolInterface
{
    private Redis $redis;

    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    /**
     * Returns a Cache Item representing the specified key.
     *
     * This method must always return a CacheItemInterface object, even in case of
     * a cache miss. It MUST NOT return null.
     *
     * @param string $key
     *   The key for which to return the corresponding Cache Item.
     *
     * @throws InvalidArgumentException
     *   If the $key string is not a legal value a \Psr\Cache\InvalidArgumentException
     *   MUST be thrown.
     *
     * @return CacheItemInterface
     *   The corresponding Cache Item.
     */
    public function getItem($key): CacheItemInterface
    {
        if (! is_string($key)) {
            throw new InvalidArgumentException('Cache key must be a legal string');
        }

        $value = $this->redis->get($key);
        $isHit = $value !== false;
        $ttl = $this->redis->ttl($key);
        $expiresAfter = $ttl !== false ? new DateInterval('PT'.$ttl.'S') : null;

        return new CacheItem($key, $value, $isHit, null, $expiresAfter);
    }

    /**
     * Returns a traversable set of cache items.
     *
     * @param string[] $keys
     *   An indexed array of keys of items to retrieve.
     *
     * @throws InvalidArgumentException
     *   If any of the keys in $keys are not a legal value a \Psr\Cache\InvalidArgumentException
     *   MUST be thrown.
     *
     * @return array|\Traversable
     *   A traversable collection of Cache Items keyed by the cache keys of
     *   each item. A Cache item will be returned for each key, even if that
     *   key is not found. However, if no keys are specified then an empty
     *   traversable MUST be returned instead.
     */
    public function getItems(array $keys = []): array
    {
        foreach ($keys as $key) {
            if (! is_string($key)) {
                throw new InvalidArgumentException('Cache key must be a legal string');
            }
        }

        $values = $this->redis->mget($keys);

        $results = array_combine($keys, $values);

        $cacheItems = [];
        foreach ($results as $key => $value) {
            $isHit = $value !== false;
            $ttl = $this->redis->ttl($key);
            $expiresAfter = $ttl !== false ? new DateInterval('PT'.$ttl.'S') : null;

            $cacheItems[] = new CacheItem($key, $value, $isHit, null, $expiresAfter);
        }

        return $cacheItems;
    }

    /**
     * Confirms if the cache contains specified cache item.
     *
     * Note: This method MAY avoid retrieving the cached value for performance reasons.
     * This could result in a race condition with CacheItemInterface::get(). To avoid
     * such situation use CacheItemInterface::isHit() instead.
     *
     * @param string $key
     *   The key for which to check existence.
     *
     * @throws InvalidArgumentException
     *   If the $key string is not a legal value a \Psr\Cache\InvalidArgumentException
     *   MUST be thrown.
     *
     * @return bool
     *   True if item exists in the cache, false otherwise.
     */
    public function hasItem($key): bool
    {
        if (! is_string($key)) {
            throw new InvalidArgumentException('Cache key must be a legal string');
        }

        return $this->redis->exists($key);
    }

    /**
     * Deletes all items in the pool.
     *
     * @return bool
     *   True if the pool was successfully cleared. False if there was an error.
     */
    public function clear(): bool
    {
        return $this->redis->flushAll();
    }

    /**
     * Removes the item from the pool.
     *
     * @param string $key
     *   The key to delete.
     *
     * @throws InvalidArgumentException
     *   If the $key string is not a legal value a \Psr\Cache\InvalidArgumentException
     *   MUST be thrown.
     *
     * @return bool
     *   True if the item was successfully removed. False if there was an error.
     */
    public function deleteItem($key): bool
    {
        if (! is_string($key)) {
            throw new InvalidArgumentException('Cache key must be a legal string');
        }

        $result = $this->redis->del($key);

        return $result === 1;
    }

    /**
     * Removes multiple items from the pool.
     *
     * @param string[] $keys
     *   An array of keys that should be removed from the pool.

     * @throws InvalidArgumentException
     *   If any of the keys in $keys are not a legal value a \Psr\Cache\InvalidArgumentException
     *   MUST be thrown.
     *
     * @return bool
     *   True if the items were successfully removed. False if there was an error.
     */
    public function deleteItems(array $keys): bool
    {
        foreach ($keys as $key) {
            if (! is_string($key)) {
                throw new InvalidArgumentException('Cache key must be a legal string');
            }
        }

        $results = $this->redis->del($keys);

        return count($keys) === $results;
    }

    /**
     * Persists a cache item immediately.
     *
     * @param CacheItemInterface $item
     *   The cache item to save.
     *
     * @return bool
     *   True if the item was successfully persisted. False if there was an error.
     */
    public function save(CacheItemInterface $item): bool
    {
        return false;
    }

    /**
     * Sets a cache item to be persisted later.
     *
     * @param CacheItemInterface $item
     *   The cache item to save.
     *
     * @return bool
     *   False if the item could not be queued or if a commit was attempted and failed. True otherwise.
     */
    public function saveDeferred(CacheItemInterface $item): bool
    {
        // TODO

        return false;
    }

    /**
     * Persists any deferred cache items.
     *
     * @return bool
     *   True if all not-yet-saved items were successfully saved or there were none. False otherwise.
     */
    public function commit(): bool
    {
        // TODO

        return false;
    }
}
