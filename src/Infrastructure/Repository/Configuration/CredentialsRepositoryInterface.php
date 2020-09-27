<?php declare(strict_types=1);

namespace Bosslike\Infrastructure\Repository\Configuration;

interface CredentialsRepositoryInterface
{
    public function getKeys(): array;
}