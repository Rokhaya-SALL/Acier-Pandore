<?php

namespace App\Security\Voter;

use App\Entity\Product;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ProductVoter extends Voter
{
    public const EDIT = 'PRODUCT_EDIT';

    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        // Vérifie que l'attribut est bien 'PRODUCT_EDIT' et que le sujet est une instance de Product
        return $attribute === self::EDIT && $subject instanceof Product;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // Si l'utilisateur n'est pas connecté ou le sujet n'est pas un produit, on refuse l'accès
        if (!$user instanceof User || !$subject instanceof Product) {
            return false;
        }

        // On autorise l'édition si l'utilisateur est un administrateur
        if ($attribute === self::EDIT && $this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        // Si le produit appartient à une certaine catégorie (à adapter selon les règles)
        if ($subject->getCategory()->getName() === 'Certain Category') {
            // Autoriser ou refuser l'accès en fonction d'autres critères
            return true; // ou false selon les règles métier
        }

        // Sinon, on refuse l'accès
        return false;
    }
}
