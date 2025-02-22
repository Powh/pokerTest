<?php

namespace App\Controller;

use App\Service\PokerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, PokerService $pokerService): Response
    {
        $hand = strtoupper(implode(" ", $request->query->all()));

        $result = $pokerService->compareWith($hand);

        return $this->render('home/index.html.twig', [
            'gameResult' => $result->name,
            'cartOne' => $request->query->get("cartOne"),
            'cartTwo' => $request->query->get("cartTwo"),
            'cartThree' => $request->query->get("cartThree"),
            'cartFour' => $request->query->get("cartFour"),
            'cartFive' => $request->query->get("cartFive"),
        ]);
    }

}
