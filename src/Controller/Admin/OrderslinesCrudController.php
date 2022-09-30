<?php

namespace App\Controller\Admin;

use App\Entity\Orderslines;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrderslinesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Orderslines::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
