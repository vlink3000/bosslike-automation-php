<?php declare(strict_types=1);

namespace Bosslike\Application\Controller;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BosslikeController extends AbstractController
{
    /**
     * @var ClientInterface
     */
    private $restClient;

    /**
     * BosslikeController constructor.
     *
     * @param ClientInterface $restClient
     */
    public function __construct(ClientInterface $restClient)
    {
        $this->restClient = $restClient;
    }

    /**
     * @Route("/bosslike", name="bosslike")
     */
    public function index()
    {
        try {
            dd($this->restClient->get('https://httpbin.org/post'));
        } catch (GuzzleException $exception) {
            dd($exception->getMessage());
        }

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/BosslikeController.php',
        ]);
    }
}
