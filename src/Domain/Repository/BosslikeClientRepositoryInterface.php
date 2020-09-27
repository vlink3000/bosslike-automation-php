<?php declare(strict_types=1);

namespace Bosslike\Domain\Repository;

interface BosslikeClientRepositoryInterface
{
    public function subscribeVk(): void;
}