<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function index(CategoryRepository $categoryRepository, TagRepository $tagRepository)
    {
        return $this->render('home/index.html.twig', [
            'categs' => $categoryRepository->findAll(),
            'tags' => $tagRepository->findAll()
        ]);
    }

}
