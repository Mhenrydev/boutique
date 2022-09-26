<?php

namespace App\Controller;

use App\Entity\Orders;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class OrdersController extends AbstractController
{
    #[Route('/order', name: 'app_orders')]
    public function index(Request $request): Response
    {
        $orderLines = [];

        $order = new Orders();
        $order->setAmount($request->request->get('amount'));
        $order->setUserId($request->request->get('user_id'));
        $order->setCreatedAt(null);
        $order->setStatus('panier');

        var_dump($order);
        return $this->render('orders/index.html.twig', [
            'email' => 'test@test.fr',
            'idOrder' => 1,
            'items' => 3,
            'amount' => 100
        ]);
    }
}
