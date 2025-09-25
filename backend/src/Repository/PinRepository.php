<?php

namespace App\Repository;

use App\Entity\Pin;
use App\Entity\Compte;
use Doctrine\ORM\EntityManagerInterface;

class PinRepository
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function insertPin(Compte $compte, string $pin, \DateTimeImmutable $expiration): Pin
    {
        $pinEntity = new Pin();
        $pinEntity->setCompte($compte)
                  ->setPin($pin)
                  ->setDateExpiration($expiration);

        $this->em->persist($pinEntity);
        $this->em->flush();

        return $pinEntity;
    }
   public function findValidPin(int $idCompte, string $pin): ?Pin
{
    $repository = $this->em->getRepository(Pin::class);

    return $repository->createQueryBuilder('p')
        ->andWhere('p.compte = :idCompte')
        ->andWhere('p.pin = :pin')
        ->andWhere('p.dateExpiration >= :now')
        ->setParameter('idCompte', $idCompte)
        ->setParameter('pin', $pin)
        ->setParameter('now', new \DateTimeImmutable())
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();
}

}
