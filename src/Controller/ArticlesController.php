<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


// Articlerepository&CategoriesRepository pour recuperer ServiceEntityRepository
// Normilizer pour transformer mes objet en tableau associatif
// group pour tagger les entités à normaliser (étiquetté dans l'entitée)
// Json_encode pour transformer mon tableau associatif en JSON
// dd pour dump $json et $articles
// Response du $json, status 200, précision du content-Type en Json

class ArticlesController extends AbstractController
{
    #[Route('/articles', name: 'app_articles')]
    public function ArticleNormalize(ArticlesRepository $articlesRepository, NormalizerInterface $normalizer)
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
    public function ConsoleNormalize(ArticlesRepository $articlesRepository, CategoriesRepository $categoriesRepository, NormalizerInterface $normalizer)
    {
        $console = $articlesRepository->findBy(array('Category' => $categoriesRepository->findById(1)));
        $consoleNormalises = $normalizer->normalize($console, null, ['groups' => 'article:read']);
        $arrayJson = [
            'isLogged' => true,
            'email' => 'test@test.fr',
            'userId' => 2,
            'articles' => $consoleNormalises
        ];
        $json = json_encode($arrayJson);
        dd($json, $console);


        $response = new Response($json, 200, ["content-Type" => "application/json"]);
        return $response;
    }

    #[Route('/articles/jeux', name: 'app_jeux')]
    public function Console2Normalize(ArticlesRepository $articlesRepository, CategoriesRepository $categoriesRepository, NormalizerInterface $normalizer)
    {
        $console = $articlesRepository->findBy(array('Category' => $categoriesRepository->findById(2)));
        $consoleNormalises = $normalizer->normalize($console, null, ['groups' => 'article:read']);
        $arrayJson = [
            'isLogged' => true,
            'email' => 'test@test.fr',
            'userId' => 2,
            'articles' => $consoleNormalises
        ];
        $json = json_encode($arrayJson);
        dd($json, $console);


        $response = new Response($json, 200, ["content-Type" => "application/json"]);
        return $response;
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
