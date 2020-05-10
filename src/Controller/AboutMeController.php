<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AboutMeController extends AbstractController
{
    /**
     * @Route("/about", name="about_me")
     */
    public function index(CategoryRepository $categorie, TagRepository $tags)
    {
        return $this->render('about_me/index.html.twig', [
            'categs' => $categorie->findAll(),
            'tags' => $tags->findAll()
        ]);
    }
}
