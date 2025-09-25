<?php

namespace App\Controller;

use App\Service\UtilisateurService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurController extends AbstractController
{
    private UtilisateurService $userService;

    public function __construct(UtilisateurService $userService)
    {
        $this->userService = $userService;
    }

    #[Route('/api/utilisateurs', name: 'api_utilisateurs', methods: ['GET'])]
    public function getAll(Request $request): JsonResponse
    {
        $compteId = $request->query->get('compteId');
        $tokenValeur = $request->query->get('token');

        if (!$compteId || !$tokenValeur) {
            return $this->json(['error' => 'Paramètres manquants'], 400);
        }

        $utilisateurs = $this->userService->getAllUtilisateurs((int)$compteId, $tokenValeur);

        if ($utilisateurs === null) {
            return $this->json(['error' => 'Token invalide ou expiré'], 401);
        }

        $data = array_map(function($u) {
            return [
                'id' => $u->getId(),
                'nom' => $u->getNom(),
                'prenom' => $u->getPrenom()
            ];
        }, $utilisateurs);

        return $this->json($data);
    }
     #[Route('/api/utilisateur/{idUser}', name: 'api_utilisateur_by_id', methods: ['GET'])]
    public function getById(Request $request, int $idUser): JsonResponse
    {
        $compteId = $request->query->get('compteId');
        $tokenValeur = $request->query->get('token');

        if (!$compteId || !$tokenValeur) {
            return $this->json(['error' => 'Paramètres manquants'], 400);
        }

        $utilisateur = $this->userService->getById((int)$compteId, $tokenValeur, $idUser);

        if ($utilisateur === null) {
            return $this->json(['error' => 'Token invalide, expiré ou utilisateur introuvable'], 401);
        }

        $data = [
            'id' => $utilisateur->getId(),
            'nom' => $utilisateur->getNom(),
            'prenom' => $utilisateur->getPrenom(),
            'mail_pro' => $utilisateur->getMailPro(),
            'mail_perso' => $utilisateur->getMailPerso(),
            'telephone' => $utilisateur->getTelephone(),
        'fonctions' => array_map(fn($f) => [
            'id' => $f->getId(),
            'libelle' => $f->getLibelle(),   // ⚠️ Assure-toi que Fonction a bien `getLibelle()`
        ], $utilisateur->getFonctions()->toArray()),

        'metiers' => array_map(fn($m) => [
            'id' => $m->getId(),
            'libelle' => $m->getLibelle(),   // ⚠️ idem pour Metier
        ], $utilisateur->getMetiers()->toArray()),

        'bureaux' => array_map(fn($b) => [
            'id' => $b->getId(),
            'nom' => $b->getNom(),           // ⚠️ idem pour Bureau
        ], $utilisateur->getBureaux()->toArray()),
        ];

        return $this->json($data);
    }

   #[Route('/api/utilisateur/{idUser}/modules', name: 'api_utilisateur_modules', methods: ['GET'])]
public function getModulesByUtilisateur(Request $request, int $idUser): JsonResponse
{
    $compteId = $request->query->get('compteId');
    $tokenValeur = $request->query->get('token');

    if (!$compteId || !$tokenValeur) {
        return $this->json(['error' => 'Paramètres manquants'], 400);
    }

    $modules = $this->userService->getAllModulesByUtilisateur((int)$compteId, $tokenValeur, $idUser);

    if ($modules === null) {
        return $this->json(['error' => 'Token invalide, expiré ou utilisateur introuvable'], 401);
    }

    $data = array_map(function($m) {
        return [
            'id'  => $m['id'],
            'nom' => $m['nom']
        ];
    }, $modules);

    return $this->json($data);
}
#[Route('/api/utilisateur/register', name: 'api_utilisateur_register', methods: ['POST'])]
public function register(Request $request): JsonResponse
{
    $data = json_decode($request->getContent(), true);

    try {
        $utilisateur = $this->userService->registerUtilisateur($data);
        $response = [
            'id' => $utilisateur->getId()
        ];

        return $this->json($response, 201);
    } catch (\InvalidArgumentException $e) {
        return $this->json(['error' => $e->getMessage()], 400);
    } catch (\Exception $e) {
        return $this->json([
            'error' => $e->getMessage()
        ], 500);
    }
}


}
