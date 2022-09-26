<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\Orderslines;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class OrdersController extends AbstractController
{
    #[Route('/order', name: 'app_orders')]
    public function index(Request $request): Response
    {
        // $orderLines = [];
        // $items = $request->request->get('items');
        // for ($i = 0; $i < $items; $i++) {
        //     $orderLines = new Orderslines();
        //     $orderLines->setQuantity($request->request->get('quantity[]'));
        //     $orderLines->set($request->request->get(''));
        //     $orderLines->set(null);
        //     $orderLines->set('panier');
        // }

        // $order = new Orders();
        // $order->setAmount($request->request->get('amount'));
        // $order->setUserId($request->request->get('user_id'));
        // $order->setCreatedAt(null);
        // $order->setStatus('panier');

        var_dump($_POST);
        return $this->render('orders/index.html.twig', [
            'email' => 'test@test.fr',
            'idOrder' => 1,
            'items' => 3,
            'amount' => 100
        ]);
    }
}
