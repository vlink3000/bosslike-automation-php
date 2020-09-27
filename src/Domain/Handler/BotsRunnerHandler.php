<?php declare(strict_types=1);

namespace Bosslike\Domain\Handler;

use Bosslike\Domain\Repository\BosslikeClientRepositoryInterface;

class BotsRunnerHandler implements BotsRunnerHandlerInterface
{
    /**
     * @var BosslikeClientRepositoryInterface
     */
    private $bosslikeClientRepository;

    /**
     * BotsRunnerHandler constructor.
     *
     * @param BosslikeClientRepositoryInterface $bosslikeClientRepository
     */
    public function __construct(BosslikeClientRepositoryInterface $bosslikeClientRepository)
    {
        $this->bosslikeClientRepository = $bosslikeClientRepository;
    }

    public function __invoke(): void
    {
        $this->bosslikeClientRepository->subscribeVk();
    }
}