<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Tag;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /* INJECTION DE DEPENDANCE*/
    private $repo;
    private $categoryRepository;
    private $tagRepository;

    public function __construct(ArticleRepository $repo, CategoryRepository $categoryRepository, TagRepository $tagRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
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

    /**
     * @Route("/tag/{id}", name="tag")
     */
    public function getArticleByTag(Tag $tag)
    {
        $articles = $tag->getArticles();
        
        return $this->render('article/index.html.twig', [
            'categs' => $this->getCategories(),
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/search", name="search-tag")
     */
    public function search()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $tag = $this->tagRepository->findOneBy(['name' => $_POST['search']]);
            $articles = [];
            if ($tag) {
                $articles = $tag->getArticles();
            }
            return $this->render('article/index.html.twig', [
                'categs' => $this->getCategories(),
                'articles' => $articles
            ]);
        }
    }

    /**
     * @Route("/comment", name="send-comment")
     */
    public function comment()
    {
        $em = $this->getDoctrine()->getManager();
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $article = $this->repo->find($_POST['article_id']);
            $comment = new Comment;
            $comment->setArticle($article);
            $comment->setContent($_POST['content']);
            $comment->setName($_POST['name']);
            $article->addComment($comment);
            $em->persist($comment);
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('articles');
        }
    }

    private function getCategories()
    {
        return $this->categoryRepository->findAll();
    }
}
