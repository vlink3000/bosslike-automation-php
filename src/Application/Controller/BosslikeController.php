<?php declare(strict_types=1);

namespace Bosslike\Application\Controller;

use Bosslike\Domain\Handler\BotsRunnerHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BosslikeController
 * @package Bosslike\Application\Controller
 */
class BosslikeController extends AbstractController
{
    /**
     * @var BotsRunnerHandlerInterface
     */
    private $botsRunnerHandler;

    /**
     * BosslikeController constructor.
     *
     * @param BotsRunnerHandlerInterface $botsRunnerHandler
     */
    public function __construct(BotsRunnerHandlerInterface $botsRunnerHandler)
    {
        $this->botsRunnerHandler = $botsRunnerHandler;
    }

    /**
     * @Route("/v1/bosslike", name="bosslike")
     */
    public function runBots(): Response
    {
        try{
            ($this->botsRunnerHandler)();
        } catch (\Exception $exception) {
            return $this->json($exception->getMessage());
        }

        return $this->json('ok');
    }
}
