<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Si l'utilisateur est déjà connecté, le rediriger en fonction de son rôle
        if ($this->getUser()) {
            // Si l'utilisateur a le rôle d'admin, le rediriger vers le tableau de bord d'EasyAdmin
            if ($this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('admin'); 
            }

            // Sinon, le rediriger vers la page d'accueil 
            return $this->redirectToRoute('homepage');
        }

        // Obtenir l'erreur de connexion s'il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();

        // Dernier nom d'utilisateur saisi par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        // Rendre le formulaire de connexion avec les erreurs éventuelles
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Symfony gère la déconnexion automatiquement.
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
