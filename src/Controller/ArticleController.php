<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Tag;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    private $articleRepository;
    private $categoryRepository;
    private $tagRepository;

    public function __construct(ArticleRepository $articleRepository, CategoryRepository $categoryRepository, TagRepository $tagRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
        $this->articleRepository = $articleRepository;
    }

    /**
     * @Route("/articles", name="articles")
     */
    public function index()
    {
        return $this->render('article/index.html.twig', [
            'categs' => $this->categoryRepository->findAll(),
            'tags' => $this->tagRepository->findAll(),
            'articles' => $this->articleRepository->findAll()
        ]);
    }

    /**
     * @Route("/read/{id}", name="read-one")
     */
    public function show(Article $article)
    {
        return $this->render('article/read.html.twig', [
            'categs' => $this->categoryRepository->findAll(),
            'tags' => $this->tagRepository->findAll(),
            'article' => $this->articleRepository->find($article)
        ]);
    }

    /**
     * @Route("/category/{id}", name="category")
     */
    public function getArticleByCategory(Category $category)
    {
        return $this->render('article/index.html.twig', [
            'categs' => $this->categoryRepository->findAll(),
            'tags' => $this->tagRepository->findAll(),
            'articles' => $category->getArticles()
        ]);
    }

    /**
     * @Route("/tag/{id}", name="tag")
     */
    public function getArticleByTag(Tag $tag)
    {
        return $this->render('article/index.html.twig', [
            'categs' => $this->categoryRepository->findAll(),
            'tags' => $this->tagRepository->findAll(),
            'articles' => $tag->getArticles()
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
                'categs' => $this->categoryRepository->findAll(),
                'tags' => $this->tagRepository->findAll(),
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
            $article = $this->articleRepository->find($_POST['article_id']);
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
}
