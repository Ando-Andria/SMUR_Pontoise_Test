<?php

namespace App\Controller;

use App\Service\AuthentificationService;
use App\Service\CompteService;
use App\Service\ServiceMail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuthentificationController extends AbstractController
{
    private AuthentificationService $authService;
    private CompteService $compteService;
    private ServiceMail $sevicemail;
    

    public function __construct(AuthentificationService $authservice,CompteService $compteService,ServiceMail $sevicemail)
    {
        $this->authService = $authservice;
        $this->compteService = $compteService;
        $this->sevicemail = $sevicemail;

    }
    #[Route('/api/hash', name: 'test', methods: ['POST'])]
    public function hash(Request $request): JsonResponse
   {
        $data = json_decode($request->getContent(), true);
        $mdp = $data['mdp'] ?? null;
        $mdphash = password_hash($mdp, PASSWORD_BCRYPT);
        return new JsonResponse([
            'mdphash'   => $mdphash,
        ]);

   } 

#[Route('/api/login', name: 'api_login', methods: ['POST'])]
public function login(Request $request): JsonResponse
{
    $data = json_decode($request->getContent(), true);

    $identifiant = $data['identifiant'] ?? null;
    $motDePasse  = $data['mot_de_passe'] ?? null;

    if (!$identifiant || !$motDePasse) {
        return new JsonResponse(['error' => 'Identifiant ou mot de passe manquant'], 400);
    }

    $result = $this->authService->seConnecter($identifiant, $motDePasse);

    if (!$result) {
        return new JsonResponse(['error' => 'Identifiant ou mot de passe incorrect'], 401);
    }

    return new JsonResponse([
    'message' => 'Connexion réussie',
    'user'    => $result
]);
}
    #[Route('/api/mdp-oublie', name: 'mdp_oublie', methods: ['POST'])]
    public function mdpOublie(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $identifiant = $data['identifiant'] ?? null;

        if (!$identifiant) {
            return new JsonResponse(['error' => 'Identifiant requis'], 400);
        }

        $idCompte = $this->compteService->getIdByIdentifiant($identifiant);

        if (!$idCompte) {
            return new JsonResponse(['error' => 'Identifiant introuvable'], 404);
        }

        return new JsonResponse([
            'idCompte' => $idCompte
        ]);
    }

    #[Route('/send-email', name: 'send_email')]
    public function sendEmail(): Response
    {
        $to = 'andoandria2386@gmail.com';
        $subject = 'Test Symfony Mailer';
        $content = '<h1>Bonjour !</h1><p>Ceci est un email envoyé depuis Symfony.</p>';
        $this->sevicemail->sendEmail($to, $subject, $content, true);

        return new Response('Email envoyé avec succès !');
    }
     #[Route('/api/check-pin', name: 'check_pin', methods: ['POST'])]
    public function checkPin(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $idCompte = $data['idcompte'] ?? null;
        $pin = $data['pin'] ?? null;

        if (!$idCompte || !$pin) {
            return new JsonResponse(['error' => 'idcompte et pin sont requis'], 400);
        }

        $isValid = $this->compteService->checkPin((int)$idCompte, (string)$pin);

        if ($isValid) {
            return new JsonResponse(['message' => 'PIN valide']);
        }

        return new JsonResponse(['error' => 'PIN invalide ou expiré'], 401);
    }
      #[Route('/api/update-password', name: 'update_password', methods: ['POST'])]
    public function updatePassword(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $idCompte = $data['idcompte'] ?? null;
        $newPassword = $data['password'] ?? null;

        if (!$idCompte || !$newPassword) {
            return new JsonResponse(['error' => 'idcompte et password requis'], 400);
        }

        $success = $this->compteService->updatePassword($idCompte, $newPassword);

        if (!$success) {
            return new JsonResponse(['error' => 'Compte introuvable'], 404);
        }

        return new JsonResponse(['message' => 'Mot de passe mis à jour avec succès']);
    }
}
