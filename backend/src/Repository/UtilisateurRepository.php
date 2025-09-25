<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UtilisateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }

    public function getAll(): array
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.nom', 'ASC') 
            ->getQuery()
            ->getResult();
    }

    public function getById(int $id): ?Utilisateur
    {
        return $this->createQueryBuilder('u')
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult(); 
    }

    public function add(Utilisateur $utilisateur, bool $flush = true): void
    {
        $em = $this->getEntityManager();
        $em->persist($utilisateur);
        if ($flush) {
            $em->flush();
        }
    }
}
