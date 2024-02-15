<?php

namespace App\Controller\Admin;

use App\Entity\Producter;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProducterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Producter::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name','Prénom'),
            TextEditorField::new('description'),
            TextField::new('city', 'Ville du partenaires'),
            ImageField::new('illustration')
                ->setBasePath('uploads/')
                ->setUploadDir('public/uploads/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false)
        ];
    }
    
}
