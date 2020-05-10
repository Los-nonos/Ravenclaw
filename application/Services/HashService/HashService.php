<?php


namespace Application\Services\HashService;

use Illuminate\Hashing\HashManager as HashManagerLaravel;

final class HashService implements HashServiceInterface
{
    private HashManagerLaravel $hashManager;

    public function __construct(HashManagerLaravel $hashManager)
    {
        $this->hashManager = $hashManager;
    }

    /**
     * Get information about the given hashed value
     * @param string $hashedValue
     * @return array
     */
    public function info(string $hashedValue): array
    {
        return $this->hashManager->info($hashedValue);
    }

    /**
     * Hash the given value
     * @param string $value
     * @param array $options
     * @return string
     */
    public function make(string $value, array $options = []): string
    {
        return $this->hashManager->make($value, $options);
    }

    /**
     * Check the given plain value against a hash
     * @param string $value
     * @param string $hashedValue
     * @param array $options
     * @return bool
     */
    public function check(string $value, string $hashedValue, array $options = []): bool
    {
        return $this->hashManager->check($value, $hashedValue, $options);
    }

    /**
     * Check if the given hash has been hashed using the given options
     * @param string $hashedValue
     * @param array $options
     * @return bool
     */
    public function needsRehash(string $hashedValue, array $options = []): bool
    {
        return $this->hashManager->needsRehash($hashedValue, $options);
    }
}
