<?php

namespace App\Controller;

use App\Entity\NewsletterEmail;
use App\Form\NewsletterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsletterController extends AbstractController
{
    #[Route('/newsletter/subscribe', name: "newsletter_subscribe", methods: ["GET", "POST"])]
    public function newsletterSubscribe(
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $newsletter = new NewsletterEmail();
        $form = $this->createForm(NewsletterType::class, $newsletter);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Check if the email already exists
            $existingEmail = $em->getRepository(NewsletterEmail::class)->findOneBy(['email' => $newsletter->getEmail()]);

            if ($existingEmail) {
                $this->addFlash('error', 'Cet email est déjà inscrit à notre newsletter.');
            } else {
                $em->persist($newsletter);
                $em->flush();

                return $this->redirectToRoute('newsletter_confirm');
            }
        }

        return $this->render('newsletter/index.html.twig', [
            'newsletterForm' => $form->createView(),
        ]);
    }

    #[Route('/newsletter/thanks', name: "newsletter_confirm")]
    public function newsletterConfirm(): Response
    {
        return $this->render('newsletter/newsletter_confirm.html.twig');
    }
}
