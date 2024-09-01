<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $imageField = ImageField::new('image')
            ->setBasePath('/uploads/images')
            ->setUploadDir('public/uploads/images')
            ->setRequired(false)
            ->setFormTypeOptions(['required' => false]);

        if ($pageName === Crud::PAGE_EDIT || $pageName === Crud::PAGE_DETAIL) {
            $product = $this->getContext()->getEntity()->getInstance();
            if ($product && strpos($product->getImage(), 'images/') === 0) {
                $imageField->setBasePath('/assets'); // Ajuste le chemin pour les images des fixtures
            }
        }

        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nom'),
            TextField::new('description', 'Description'),
            TextField::new('price', 'Prix'),
            $imageField,
            AssociationField::new('category', 'Catégorie')->autocomplete(),
            DateTimeField::new('updatedAt', 'Date de mise à jour')->hideOnForm(),
        ];
    }
}
