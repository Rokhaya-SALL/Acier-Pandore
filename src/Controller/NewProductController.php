<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class NewProductController extends AbstractController
{
    #[Route('/product/add', name: 'product_add')]
    public function addProduct(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $filename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        'uploads/product/',
                        $filename
                    );
                } catch (FileException $e) {
                    $form->addError(new FormError("Erreur lors de l'upload du fichier"));
                }

                $product->setImage($filename);
            }

            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_list'); // adjust to your product listing route
        }

        return $this->render('new_product/index.html.twig', [
            'productForm' => $form->createView(),
        ]);
    }
}
