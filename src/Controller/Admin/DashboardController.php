<?php

namespace App\Controller\Admin;

use App\Entity\Articles;
use App\Entity\Categories;
use App\Entity\User;
use App\Entity\Orders;
use App\Entity\Orderslines;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;



class DashboardController extends AbstractDashboardController
{
//     public function __construct(
//         private AdminUrlGenerator $adminUrlGenerator
// )

// {  
// }
    #[Route('/dev/admin', name: 'admin')]
    public function index(): Response
    {
        // $url = $this->adminUrlGenerator->setController(ArticlesCrudController::class)->generateUrl();

        // return $this->redirect($url);
        return $this->render(view:'admin/dashboard.html.twig');

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Boutique Admin');
            
    }

    public function configureMenuItems(): iterable
    {
        return[
        MenuItem::linkToCrud('Articles', 'fas fa-tags', Articles::class),
        MenuItem::linkToCrud('Categories', 'fas fa-newspaper', Categories::class),
        MenuItem::linkToCrud('Users', 'fas fa-user', User::class),
        MenuItem::linkToCrud('Orders', 'fas fa-user', Orders::class),
        MenuItem::linkToCrud('Orderslines', 'fas fa-user', Orderslines::class),
        ];
    }

}
