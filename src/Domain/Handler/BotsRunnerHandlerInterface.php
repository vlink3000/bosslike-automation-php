<?php declare(strict_types=1);

namespace Bosslike\Domain\Handler;

interface BotsRunnerHandlerInterface
{
    /**
     * @return void
     */
    public function __invoke(): void;
}