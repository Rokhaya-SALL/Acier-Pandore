<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'product_list')]
    public function list(ProductRepository $productRepository, Request $request): Response
    {
        $search = $request->query->get('search', '');
        $products = $productRepository->findByTitleOrDescription($search);

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/update', name: 'product_update')]
    public function updateList(ProductRepository $productRepository, Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
        }

        $search = $request->query->get('search', '');
        $products = $productRepository->findByTitleOrDescription($search);

        return $this->render('new_product/update.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/product/{id}', name: 'product_item')]
    public function item(Product $product): Response
    {
        return $this->render('product/item.html.twig', [
            'product' => $product,
        ]);
    }
}
