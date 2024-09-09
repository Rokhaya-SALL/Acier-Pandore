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
        // Initialisation du champ d'image avec les deux chemins possibles
        $imageField = ImageField::new('image', 'Image')
            ->setUploadDir('public/uploads/images')  // Répertoire de téléchargement pour les nouvelles images
            ->setUploadedFileNamePattern('[randomhash].[extension]')  // Nom de fichier unique
            ->setRequired(false);

        // Gestion du chemin d'affichage en fonction de l'emplacement de l'image
        $product = $this->getContext()->getEntity()->getInstance();

        if ($product && $product->getImage()) {
            $imagePath = $product->getImage();

            if (strpos($imagePath, 'images/') === 0) {
                // Si l'image est dans le répertoire public/images
                $imageField->setBasePath('/images');
            } else {
                // Sinon, l'image est dans uploads/images
                $imageField->setBasePath('/uploads/images');
            }
        }

        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nom'),
            TextField::new('description', 'Description'),
            TextField::new('price', 'Prix'),
            $imageField,  // Champ pour gérer l'image
            AssociationField::new('category', 'Catégorie')->autocomplete(),
            DateTimeField::new('updatedAt', 'Date de mise à jour')->hideOnForm(),
        ];
    }
}
