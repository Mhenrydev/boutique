<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Orders;
use App\Entity\Orderslines;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\Persistence\ManagerRegistry;

class OrdersController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/order', name: 'app_orders')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $session = $this->requestStack->getSession();

        $em = $doctrine->getManager();
        $rep = $doctrine->getRepository(Articles::class);
        $repUser = $doctrine->getRepository(User::class);
        
        $amount = $request->request->get('amount');
        $session->set('amount',$amount);

        $user = $repUser->find($request->request->get('user_id'));

        $order = new Orders();
        $order->setAmount($amount);
        $order->setUser($user);
        $order->setCreatedAt(null);
        $order->setStatus('panier');

        $em->persist($order);
        $em->flush();

        $lineNb = $request->request->get('lineNb');
        for ($i = 1; $i <= $lineNb; $i++) {
            $orderLine = new Orderslines();
            $orderLine->setQuantity($request->request->get('quantity' . $i));
            $orderLine->setArticle($rep->find($request->request->get('idArticle' . $i)));
            $orderLine->setOrders($order);
            $em->persist($orderLine);
        }
        $em->flush();

        $items = $request->request->get('items');
        $session->set('items',$items);
        $session->set('idOrder',$order->getId());
        $msg = $session->get('msg','');
        $session->remove('msg');

        return $this->render('orders/index.html.twig', [
            'email' => $user->getEmail(),
            'idOrder' => $order->getId(),
            'items' => $items,
            'amount' => $amount,
            'msg' => $msg
        ]);
    }

    #[Route('/order/delete/{id}', name: 'app_order_delete')]
    public function deleteOrder(Orders $order, ManagerRegistry $doctrine): Response
    {
        $session = $this->requestStack->getSession();

        $em = $doctrine->getManager();
        $em->remove($order);
        $em->flush();
        
        $session->set('msg','Commande annulée');
        
        return $this->redirectToRoute('app_home');
    }

    #[Route('/payment', name: 'app_payment')]
    public function show(): Response
    {
        $session = $this->requestStack->getSession();
        $items = $session->get('items',0);
        $amount = $session->get('amount',0);
        $idOrder = $session->get('idOrder');
        $email = $session->get('email','');
        $msg = $session->get('msg','');
        $session->remove('msg');

        return $this->render('orders/index.html.twig', [
            'email' => $email,
            'idOrder' => $idOrder,
            'items' => $items,
            'amount' => $amount,
            'msg' => $msg
        ]);
    }
}
