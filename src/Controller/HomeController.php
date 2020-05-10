<?php

namespace App\Controller;

use App\Service\GetCategorieService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function index(GetCategorieService $getCategorieService)
    {
        return $this->render('home/index.html.twig', [
            'categs' => $getCategorieService->categorie()
        ]);
    }

}
