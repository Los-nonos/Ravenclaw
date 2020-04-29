<?php
declare(strict_types=1);

namespace Infrastructure\Hash;

use Illuminate\Hashing\HashManager as HashManagerLaravel;

final class HashManager implements HashManagerInterface
{
    private HashManagerLaravel $hashManager;

    public function __construct(HashManagerLaravel $hashManager)
    {
        $this->hashManager = $hashManager;
    }

    /**
     * Get information about the given hashed value
     */
    public function info(string $hashedValue): array
    {
        return $this->hashManager->info($hashedValue);
    }

    /**
     * Hash the given value
     */
    public function make(string $value, array $options = []): string
    {
        return $this->hashManager->make($value, $options);
    }

    /**
     * Check the given plain value against a hash
     */
    public function check(string $value, string $hashedValue, array $options = []): bool
    {
        return $this->hashManager->check($value, $hashedValue, $options);
    }

    /**
     * Check if the given hash has been hashed using the given options
     */
    public function needsRehash(string $hashedValue, array $options = []): bool
    {
        return $this->hashManager->needsRehash($hashedValue, $options);
    }
}
