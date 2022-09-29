<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;


// Articlerepository&CategoriesRepository pour recuperer ServiceEntityRepository
// group pour tagger les entités à normaliser (étiquetté dans l'entitée)
// Json pour transformer mon tableau associatif en JSON


class ArticlesController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $session = $this->requestStack->getSession();
        
        if ($session->get('isLogged',false))
        {
            if ($session->get('user_id',0) == 0)
            {
                $email = $session->get('email','');
                $rep = $doctrine->getRepository(User::class);
                $user = $rep->findOneBy(['email' => $email]);
                $userId = $user->getId();
                $session->set('user_id',$userId);
            }
        }
        return $this->render('articles/index.html.twig');
    }

    #[Route('/articles', name: 'app_articles')]
    public function ArticleNormalize(ArticlesRepository $articlesRepository): JsonResponse
    {
        $session = $this->requestStack->getSession();
        $email = $session->get('email','');
        $isLogged = $session->get('isLogged',false);
        $userId = $session->get('user_id',0);

        $articles = $articlesRepository->findAll();
        $articlesNormalises = [];
        foreach ($articles as $article) {
            $articlesNormalises[] = $this->articleToArray($article);
        }
        $msg = $session->get('msg','');
        $session->remove('msg');

        $arrayJson = [
            'isLogged' => $isLogged,
            'email' => $email,
            'userId' => $userId,
            'articles' => $articlesNormalises,
            'msg' => $msg
        ];
        return $this->json($arrayJson);
    }

    #[Route('/articles/console', name: 'app_console')]
    public function ConsoleNormalize(ArticlesRepository $articlesRepository, CategoriesRepository $categoriesRepository): JsonResponse
    {
        $session = $this->requestStack->getSession();
        $email = $session->get('email','');
        $isLogged = $session->get('isLogged',false);
        $userId = $session->get('user_id',0);

        $consoles = $articlesRepository->findBy(array('Category' => $categoriesRepository->findById(1)));
        $consolesNormalises = [];
        foreach ($consoles as $console) {
            $consolesNormalises[] = $this->articleToArray($console);
        }
        $msg = $session->get('msg','');
        $session->remove('msg');

        $arrayJson = [
            'isLogged' => $isLogged,
            'email' => $email,
            'userId' => $userId,
            'articles' => $consolesNormalises,
            'msg' => $msg
        ];
        return $this->json($arrayJson);
    }

    #[Route('/articles/jeux', name: 'app_jeux')]
    public function Console2Normalize(ArticlesRepository $articlesRepository, CategoriesRepository $categoriesRepository): JsonResponse
    {
        $session = $this->requestStack->getSession();
        $email = $session->get('email','');
        $isLogged = $session->get('isLogged',false);
        $userId = $session->get('user_id',0);

        $jeux = $articlesRepository->findBy(array('Category' => $categoriesRepository->findById(2)));
        $jeuxNormalises = [];
        foreach ($jeux as $jeu) {
            $jeuxNormalises[] = $this->articleToArray($jeu);
        }
        $msg = $session->get('msg','');
        $session->remove('msg');

        $arrayJson = [
            'isLogged' => $isLogged,
            'email' => $email,
            'userId' => $userId,
            'articles' => $jeuxNormalises,
            'msg' => $msg
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
