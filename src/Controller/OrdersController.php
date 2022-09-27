<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Orders;
use App\Entity\Orderslines;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\Persistence\ManagerRegistry;

class OrdersController extends AbstractController
{
    #[Route('/order', name: 'app_orders')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $rep = $doctrine->getRepository(Articles::class);

        $amount = $request->request->get('amount');

        $order = new Orders();
        $order->setAmount($amount);
        $order->setUserId($request->request->get('user_id'));
        $order->setCreatedAt(null);
        $order->setStatus('panier');

        $em->persist($order);
        $em->flush();
        // $idOrder = $order->getId();

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

        return $this->render('orders/index.html.twig', [
            'email' => 'test@test.fr',
            'idOrder' => $order->getId(),
            'items' => $items,
            'amount' => $amount
        ]);
    }

    #[Route('/order/delete/{id}', name: 'app_order_delete')]
    public function deleteOrder(Orders $order, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $em->remove($order);
        $em->flush();


        return $this->redirectToRoute('app_home');
    }
}
