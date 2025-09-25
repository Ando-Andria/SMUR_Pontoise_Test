<?php

namespace App\Service;

use App\Repository\UtilisateurRepository;
use App\Repository\TokenCompteRepository;
use App\Repository\ModuleRepository;
use App\Entity\TokenCompte;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;
use DateTimeImmutable;

class UtilisateurService
{
    private UtilisateurRepository $utilisateurRepository;
    private TokenCompteRepository $tokenRepository;
    private ModuleRepository $moduleRepository;
    private EntityManagerInterface $em;
    public function __construct(
        UtilisateurRepository $utilisateurRepository,
        TokenCompteRepository $tokenRepository,
        ModuleRepository $moduleRepository,
        EntityManagerInterface $em
    ) {
        $this->utilisateurRepository = $utilisateurRepository;
        $this->tokenRepository = $tokenRepository;
        $this->moduleRepository = $moduleRepository;
        $this->em = $em;

    }
    public function getAllUtilisateurs(int $compteId, string $tokenValeur): ?array
    {
        $token = $this->tokenRepository->findValidToken($compteId,$tokenValeur);
        if (!$token) {
            return null;
        }
        return $this->utilisateurRepository->getAll();
    }
    public function getById(int $compteId, string $tokenValeur,int $idUser): ?Utilisateur
    {
        $token = $this->tokenRepository->findValidToken($compteId,$tokenValeur);
        if (!$token) {
            return null;
        }
        return $this->utilisateurRepository->getById($idUser);
    }
   public function getAllModulesByUtilisateur(int $compteId, string $tokenValeur, int $idUser): ?array
    {
        $token = $this->tokenRepository->findValidToken($compteId, $tokenValeur);
        if (!$token) {
            return null; 
        }
        return $this->moduleRepository->getByUtilisateur($idUser);
    }
    public function registerUtilisateur(array $data): Utilisateur
    {
        $this->validateRegistrationData($data);

        $compte = $this->createCompte($data);

        $utilisateur = $this->createUtilisateur($data, $compte);

        $this->em->persist($compte);
        $this->utilisateurRepository->add($utilisateur);

        return $utilisateur;
    }
    private function validateRegistrationData(array $data): void
    {
        if (empty($data['nom']) || empty($data['prenom'])) {
            throw new \InvalidArgumentException("Nom et prénom sont obligatoires");
        }
        if (empty($data['mot_de_passe'])) {
            throw new \InvalidArgumentException("Le mot de passe est obligatoire");
        }
        if (empty($data['mail_pro']) && empty($data['mail_perso'])) {
            throw new \InvalidArgumentException("Au moins un email (pro ou perso) doit être fourni");
        }
    }

    private function createCompte(array $data): \App\Entity\Compte
    {
        $compte = new \App\Entity\Compte();

        if (!empty($data['identifiant'])) {
            $compte->setIdentifiant($data['identifiant']);
        } elseif (!empty($data['mail_pro'])) {
            $compte->setIdentifiant($data['mail_pro']);
        } else {
            $compte->setIdentifiant($data['mail_perso']);
        }
        $hashedPassword = password_hash($data['mot_de_passe'], PASSWORD_BCRYPT);
        $compte->setMotDePasse($hashedPassword);
        return $compte;
    }
    private function createUtilisateur(array $data, \App\Entity\Compte $compte): Utilisateur
    {
        $utilisateur = new Utilisateur();
        $utilisateur->setNom($data['nom']);
        $utilisateur->setPrenom($data['prenom']);
        $utilisateur->setMailPro($data['mail_pro'] ?? null);
        $utilisateur->setMailPerso($data['mail_perso'] ?? null);
        $utilisateur->setTelephone($data['telephone'] ?? null);
        $utilisateur->setCompte($compte);
        return $utilisateur;
    }
    
}
