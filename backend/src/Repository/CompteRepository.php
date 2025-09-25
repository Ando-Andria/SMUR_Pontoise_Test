<?php

namespace App\Repository;

use App\Entity\Compte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CompteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Compte::class);
    }

    public function findByIdentifiant(string $identifiant): ?Compte
    {
        return $this->createQueryBuilder('c')
            ->where('c.identifiant = :identifiant')
            ->setParameter('identifiant', $identifiant)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function updatePassword(Compte $compte, string $newPassword): void
    {
        $compte->setMotDePasse(password_hash($newPassword, PASSWORD_BCRYPT));
        $this->getEntityManager()->persist($compte);
        $this->getEntityManager()->flush();
    }

    public function findById(int $id): ?Compte
    {
        return $this->getEntityManager()->getRepository(Compte::class)->find($id);
    }
}
