<?php declare(strict_types=1);

namespace Bosslike\Domain\Repository;

interface BosslikeClientRepositoryInterface
{
    /**
     * @return void
     */
    public function subscribeVk(): void;
}