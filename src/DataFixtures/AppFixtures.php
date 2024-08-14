<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private const CATEGORIES = ['Bague', 'Bracelet', 'Collier', 'Boucle d\'oreille'];

    public function load(ObjectManager $manager): void
    {
        $categories = [];
        foreach (self::CATEGORIES as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            $categories[] = $category;
        }

        $products = [
            ['Bracelet en acier inoxydable', 'Un bracelet élégant en acier inoxydable de haute qualité.', 49, 'bijoux19.jpg', 'Bracelet'],
            ['Collier en acier inoxydable', 'Un collier raffiné en acier inoxydable, parfait pour toutes les occasions.', 69, 'bijoux18.jpg', 'Collier'],
            ['Boucles d\'oreilles en acier inoxydable', 'Des boucles d\'oreilles en acier inoxydable, résistantes et brillantes.', 29, 'bijoux8.jpg', 'Boucle d\'oreille'],
            ['Boucles d\'oreilles en acier inoxydable', 'Des boucles d\'oreilles en acier inoxydable, résistantes et brillantes.', 29, 'bijoux10.jpg', 'Boucle d\'oreille'],
            ['Boucles d\'oreilles en acier inoxydable', 'Des boucles d\'oreilles en acier inoxydable, résistantes et brillantes.', 29, 'bijoux15.jpg', 'Boucle d\'oreille'],
            ['Boucles d\'oreilles en acier inoxydable', 'Des boucles d\'oreilles en acier inoxydable, résistantes et brillantes.', 29, 'bijoux16.jpg', 'Boucle d\'oreille'],
            ['Boucles d\'oreilles en acier inoxydable', 'Des boucles d\'oreilles en acier inoxydable, résistantes et brillantes.', 29, 'bijoux17.jpg', 'Boucle d\'oreille'],
            ['Bagues en acier inoxydable', 'Lot de 3 bagues en acier inoxydable avec un design intemporel.', 39, 'bijoux1.jpg', 'Bague'],
            ['Bagues en acier inoxydable', 'Lot de 3 bagues en acier inoxydable avec un design intemporel.', 39, 'bijoux2.jpg', 'Bague'],
            ['Bagues en acier inoxydable', 'Lot de 4 bagues en acier inoxydable avec un design intemporel.', 39, 'bijoux3.jpg', 'Bague'],
            ['Bagues en acier inoxydable', 'Lot de 2 bagues en acier inoxydable avec un design intemporel.', 39, 'bijoux4.jpg', 'Bague'],
            ['Bague en acier inoxydable', 'Une bague en acier inoxydable avec un design intemporel.', 39, 'bijoux5.jpg', 'Bague'],
            ['Bagues en acier inoxydable', 'Lot de 3 bagues en acier inoxydable avec un design intemporel.', 39, 'bijoux6.jpg', 'Bague'],
            ['Bague en acier inoxydable', 'Une bague en acier inoxydable avec un design intemporel.', 39, 'bijoux7.jpg', 'Bague'],
            ['Bague en acier inoxydable', 'Une bague en acier inoxydable avec un design intemporel.', 39, 'bijoux9.jpg', 'Bague'],
            ['Bagues en acier inoxydable', 'Lot de 4 bagues en acier inoxydable avec un design intemporel.', 39, 'bijoux14.jpg', 'Bague'],
            
        ];

        foreach ($products as $data) {
            $product = new Product();
            $product->setName($data[0])
                    ->setDescription($data[1])
                    ->setPrice($data[2])
                    ->setImage($data[3]);

            
            foreach ($categories as $category) {
                if ($category->getName() === $data[4]) {
                    $product->setCategory($category);
                    break;
                }
            }

            $manager->persist($product);
        }

        $manager->flush();
    }
}
