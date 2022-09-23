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
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('articles/index.html.twig');
    }

    #[Route('/articles', name: 'app_articles')]
    public function ArticleNormalize(ArticlesRepository $articlesRepository, NormalizerInterface $normalizer)
    {

        $articles = $articlesRepository->findAll();
        $articlesNormalises = $normalizer->normalize($articles, null, ['groups' => 'article:read']);
        $arrayJson = [
            'isLogged' => true,
            'email' => 'test@test.fr',
            'userId' => 2,
            'articles' => $articlesNormalises
        ];
        $json = json_encode($arrayJson);
        dd($json, $articles);


        $response = new Response($json, 200, ["content-Type" => "application/json"]);
        return $response;
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

    #[Route('article/getAllArticles', name:'allArticles')]
    function getAllArticles(): JsonResponse
    {
        return $this->json([
            'isLogged' => true,
            'articles' => [
                [
                    'id' => 1,
                    'nameArticle' => 'Console PS4',
                    'price' => 299,
                    'image' => 'console-ps4.jpg',
                    'description' => 'Pour l\'achat d\'une console PS4 ou d\'un accessoire de la sélection profitez du jeu Destiny 2 offert si vous l\'ajoutez au panier !',
                    'nameCategory' => 'console',
                    'type' => 'new',
                    'rating' => '4' 
                ],
                [
                    'id' => 2,
                    'nameArticle' => 'Console Wii U',
                    'price' => 489,
                    'image' => 'Console-Wii-U.jpg',
                    'description' => 'Pack Nintendo Premium Console Wii U + Mario Kart 8 + Code Splatoon',
                    'nameCategory' => 'console',
                    'type' => 'new',
                    'rating' => '4'
                ],
                [
                    'id' => 4,
                    'nameArticle' => 'Assassin\'s Creed PS4',
                    'price' => 56,
                    'image' => 'Aain-s-Creed-Origins-PS4.jpg',
                    'description' => 'Un nouvel opus de la saga Assassin\'s Creed qui regorge de nouveautés techniques.',
                    'nameCategory' => 'game',
                    'type' => 'new',
                    'rating' => '4'
                ],
                [
                    'id' => 5,
                    'nameArticle' => 'Dragon Ball Fighter',
                    'price' => 55,
                    'image' => 'Dragon-Ball-Fighter-Z-Xbox-One.jpg',
                    'description' => 'DRAGON BALL FighterZ reprend les éléments qui ont fait le succès de la série DRAGON BALL : des combats spectaculaires avec des combattants aux pouvoirs incroyables.',
                    'nameCategory' => 'game',
                    'type' => 'new',
                    'rating' => '4'
                ]
            ],
            'email' => 'bob@p7.fr',
            'idUser' => 1
        ]);
    }
}
