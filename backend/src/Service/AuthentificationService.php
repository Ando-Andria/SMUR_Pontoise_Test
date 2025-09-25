<?php

namespace App\Service;

use App\Repository\CompteRepository;
use App\Entity\Compte;
use App\Entity\TokenCompte;
use Doctrine\ORM\EntityManagerInterface;

class AuthentificationService
{
    private CompteRepository $compteRepository;
    private EntityManagerInterface $em;

    public function __construct(CompteRepository $compteRepository, EntityManagerInterface $em)
    {
        $this->compteRepository = $compteRepository;
        $this->em = $em;
    }

public function seConnecter(string $identifiant, string $motDePasse): ?array
{
    $compte = $this->trouverCompte($identifiant);

    if (!$compte || !$this->verifierMotDePasse($compte, $motDePasse)) {
        return null;
    }

    $this->mettreAJourDerniereConnexion($compte);

    $token = $this->creerTokenPourCompte($compte);

    return [
        'user' => [
            'userId' => $compte->getUtilisateur()?->getId() ?? null,
            'compteId' => $compte->getId(),
            'token' => $token->getValeur()
        ]
    ];
}

    private function trouverCompte(string $identifiant): ?Compte
    {
        return $this->compteRepository->findByIdentifiant($identifiant);
    }

    private function verifierMotDePasse(Compte $compte, string $motDePasse): bool
    {
            return password_verify($motDePasse, $compte->getMotDePasse());
    }

    private function mettreAJourDerniereConnexion(Compte $compte): void
{
    $compte->setDerniereConnexion(new \DateTimeImmutable());
    $this->em->persist($compte);
    $this->em->flush(); 
}


    private function creerTokenPourCompte(Compte $compte): TokenCompte
    {
        $token = new TokenCompte();
        $token->setId(uniqid());
        $token->setValeur(bin2hex(random_bytes(16)));
        $token->setIdCompte($compte->getId());
        $token->setDateExpiration((new \DateTimeImmutable())->modify('+1 hour'));

        $this->em->persist($token);
        $this->em->flush();

        return $token;
    }

}
