<?php

namespace App\Controller\Admin;

use App\Entity\Delivery;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DeliveryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Delivery::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return[
        TextField::new('name', 'Titre'),
        MoneyField::new('price', 'Prix')->setCurrency('EUR')
        ];
    }

   

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable('new') // Désactiver l'action 'new' pour empêcher l'ajout de nouvelles livraisons
            ->disable('delete');
    }
}

