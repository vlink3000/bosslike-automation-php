<?php declare(strict_types=1);

namespace Bosslike\Infrastructure\Repository\Configuration;

interface CredentialsRepositoryInterface
{
    /**
     * @return array
     */
    public function getKeys(): array;
}