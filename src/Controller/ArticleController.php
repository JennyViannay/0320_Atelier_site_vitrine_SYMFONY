<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /* INJECTION DE DEPENDANCE*/
    private $repo;
    private $categoryRepository;

    public function __construct(ArticleRepository $repo, CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->repo = $repo;
    }

    /**
     * @Route("/", name="articles")
     */
    public function index()
    {
        $articles = $this->repo->findAll();
        return $this->render('article/index.html.twig', [
            'categs' => $this->getCategories(),
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/read/{id}", name="read-one")
     */
    public function show(Article $article)
    {
        return $this->render('article/read.html.twig', [
            'article' => $this->repo->find($article),
            'categs' => $this->getCategories(),
        ]);
    }

    /**
     * @Route("/category/{id}", name="category")
     */
    public function getArticleByCategory(Category $category)
    {
        $articles = $this->repo->findBy(['category' => $category]);
        return $this->render('article/index.html.twig', [
            'categs' => $this->getCategories(),
            'articles' => $articles
        ]);
    }

    private function getCategories(){
        return $this->categoryRepository->findAll();
    }
}
