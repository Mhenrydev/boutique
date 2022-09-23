<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


// Articlerepository&CategoriesRepository pour recuperer ServiceEntityRepository
// group pour tagger les entités à normaliser (étiquetté dans l'entitée)
// Json pour transformer mon tableau associatif en JSON


class ArticlesController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('articles/index.html.twig');
    }

    #[Route('/articles', name: 'app_articles')]
    public function ArticleNormalize(ArticlesRepository $articlesRepository): JsonResponse
    {

        $articles = $articlesRepository->findAll();
        $articlesNormalises = [];
        foreach ($articles as $article) {
            $articlesNormalises[] = $this->articleToArray($article);
        }
        $arrayJson = [
            'isLogged' => true,
            'email' => 'test@test.fr',
            'userId' => 2,
            'articles' => $articlesNormalises
        ];
        return $this->json($arrayJson);
    }

    #[Route('/articles/console', name: 'app_console')]
    public function ConsoleNormalize(ArticlesRepository $articlesRepository, CategoriesRepository $categoriesRepository): JsonResponse
    {
        $consoles = $articlesRepository->findBy(array('Category' => $categoriesRepository->findById(1)));
        $consolesNormalises = [];
        foreach ($consoles as $console) {
            $consolesNormalises[] = $this->articleToArray($console);
        }
        $arrayJson = [
            'isLogged' => true,
            'email' => 'test@test.fr',
            'userId' => 2,
            'articles' => $consolesNormalises
        ];
        return $this->json($arrayJson);
    }

    #[Route('/articles/jeux', name: 'app_jeux')]
    public function Console2Normalize(ArticlesRepository $articlesRepository, CategoriesRepository $categoriesRepository): JsonResponse
    {
        $jeux = $articlesRepository->findBy(array('Category' => $categoriesRepository->findById(2)));
        $jeuxNormalises = [];
        foreach ($jeux as $jeu) {
            $jeuxNormalises[] = $this->articleToArray($jeu);
        }
        $arrayJson = [
            'isLogged' => true,
            'email' => 'test@test.fr',
            'userId' => 2,
            'articles' => $jeuxNormalises
        ];
        return $this->json($arrayJson);
    }

    public function articleToArray($articles)
    {
        return  [
            'id' => $articles->getId(),
            'nameArticle' => $articles->getNameArticle(),
            'price' => $articles->getPrice(),
            'rating' => $articles->getRating(),
            'image' => $articles->getImage()
        ];
    }
}
