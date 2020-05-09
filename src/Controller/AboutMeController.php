<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AboutMeController extends AbstractController
{
    /* INJECTION DE DEPENDANCE*/
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/about", name="about_me")
     */
    public function index()
    {
        return $this->render('about_me/index.html.twig', [
            'categs' => $this->getCategories()
        ]);
    }

    private function getCategories()
    {
        return $this->categoryRepository->findAll();
    }
}
