<?php

namespace App\Controller;

use App\Service\GetCategorieService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AboutMeController extends AbstractController
{
    /**
     * @Route("/about", name="about_me")
     */
    public function index(GetCategorieService $getCategorieService)
    {
        return $this->render('about_me/index.html.twig', [
            'categs' => $getCategorieService->categorie()
        ]);
    }
}
