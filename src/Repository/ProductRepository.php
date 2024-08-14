<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }
     /**
     * @return Product[]
     */
    public function findByTitleOrDescription(string $search): array
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.name LIKE :search OR j.description LIKE :search')
            ->setParameter('search', '%'.$search.'%')
            ->orderBy('j.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
