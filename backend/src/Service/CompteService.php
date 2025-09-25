<?php

namespace App\Service;

use App\Repository\CompteRepository;
use App\Repository\PinRepository;
use App\Config\AppConfig;
use App\Service\ServiceMail;

class CompteService
{
    private CompteRepository $compteRepository;
    private PinRepository $pinRepository;
    private ServiceMail $servicemail;
    

    public function __construct(CompteRepository $compteRepository,ServiceMail $servicemail,PinRepository $pinRepository)
    {
        $this->compteRepository = $compteRepository;
        $this->servicemail = $servicemail;
        $this->pinRepository = $pinRepository;
    }
    public function genere_pin(): int {
        $longueurPin = AppConfig::LONGUEUR_PIN;
        $pin = '';
        for ($i = 0; $i < $longueurPin; $i++) {
            $pin .= rand(0, 9);  
        }
        return (int) $pin;
    }
    public function getIdByIdentifiant(string $identifiant): ?int
    {
        $compte = $this->compteRepository->findByIdentifiant($identifiant);
        if (!$compte) {
            return null;
        }

        $pin = $this->genere_pin();
        $expiration = new \DateTimeImmutable('+10 minutes');

        $this->pinRepository->insertPin($compte, $pin, $expiration);

        $subject = 'Votre code de réinitialisation';
        $content = "
            Bonjour,<br><br>
            Voici votre code PIN pour réinitialiser votre mot de passe : <b>{$pin}</b><br><br>
            Ce code expire dans 10 minutes.
        ";
        $this->servicemail->sendEmail($identifiant, $subject, $content, true);

        return $compte->getId();
    }
     public function checkPin(int $idCompte, string $pin): bool
    {
        $result = $this->pinRepository->findValidPin($idCompte, $pin);
        return $result !== null;
    }
    public function updatePassword(int $idCompte, string $newPassword): bool
    {
        $compte = $this->compteRepository->findById($idCompte);

        if (!$compte) {
            return false; 
        }

        $this->compteRepository->updatePassword($compte, $newPassword);

        return true;
    }
}