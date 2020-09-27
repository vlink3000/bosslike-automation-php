<?php declare(strict_types=1);

namespace Bosslike\Domain\Handler;

interface BotsRunnerHandlerInterface
{
    public function __invoke(): void;
}