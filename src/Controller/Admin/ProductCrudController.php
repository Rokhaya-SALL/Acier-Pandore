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
        $product = $this->getContext()->getEntity()->getInstance();

        // Créez le champ d'image avec une configuration de base
        $imageField = ImageField::new('image')
            ->setRequired(false)
            ->setFormTypeOptions(['required' => false]);

        // Détermine le chemin de base en fonction de l'origine de l'image
        if ($product && strpos($product->getImage(), 'images/') === 0) {
            // Image ajoutée manuellement dans le dossier 'assets/images'
            $imageField->setBasePath('/assets/images');
        } else {
            // Image téléversée par l'utilisateur dans le dossier 'uploads/images'
            $imageField->setBasePath('/uploads/images')
                       ->setUploadDir('public/uploads/images');
        }

        // Retourne la configuration des champs
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
