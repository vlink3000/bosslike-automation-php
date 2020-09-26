<?php declare(strict_types=1);

namespace Bosslike\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BosslikeController extends AbstractController
{
    /**
     * @Route("/bosslike", name="bosslike")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/BosslikeController.php',
        ]);
    }
}
