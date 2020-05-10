<?php

namespace App\Service;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class GetCategorieService
{
    private $categorie;

    public function __construct(CategoryRepository $categorie)
    {
        $this->categorie = $categorie;
    }

    public function categorie()
    {
        return $this->categorie->findAll();
    }
}
