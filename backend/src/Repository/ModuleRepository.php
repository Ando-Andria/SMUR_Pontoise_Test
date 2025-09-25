<?php

namespace App\Repository;

use App\Entity\Module;
use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ModuleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Module::class);
    }

public function getByUtilisateur(int $userId): array
{
    $conn = $this->getEntityManager()->getConnection();
    $sql = '
        SELECT m.*
        FROM module m
        INNER JOIN utilisateur_module um ON m.id = um.module_id
        WHERE um.utilisateur_id = :userId
        ORDER BY m.nom ASC
    ';
     $result = $conn->executeQuery($sql, ['userId' => $userId]);
    return $result->fetchAllAssociative();
}


}
