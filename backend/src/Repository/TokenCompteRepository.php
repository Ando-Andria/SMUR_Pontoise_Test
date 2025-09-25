<?php

namespace App\Repository;

use App\Entity\TokenCompte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TokenCompteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TokenCompte::class);
    }
    public function findValidToken(int $compteId, string $valeurToken): ?TokenCompte
    {
        $token = $this->findOneBy([
            'idCompte' => $compteId,
            'valeur' => $valeurToken
        ]);

        if ($token && $token->getDateExpiration() >= new \DateTimeImmutable()) {
            return $token;
        }
        return null;
    }
}
