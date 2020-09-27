<?php declare(strict_types=1);

namespace Bosslike\Infrastructure\Repository\Bosslike;

use Bosslike\Domain\Repository\BosslikeClientRepositoryInterface;
use Bosslike\Infrastructure\Repository\Configuration\CredentialsRepositoryInterface;

class BosslikeClientRepository implements BosslikeClientRepositoryInterface
{
    /**
     * @var CredentialsRepositoryInterface
     */
    private $credentialsRepository;

    /**
     * BosslikeClientRepository constructor.
     *
     * @param CredentialsRepositoryInterface $credentialsRepository
     */
    public function __construct(CredentialsRepositoryInterface $credentialsRepository)
    {
        $this->credentialsRepository = $credentialsRepository;
    }

    /**
     * @return void
     */
    public function subscribeVk(): void
    {
        dd($this->credentialsRepository->getKeys());
    }
}