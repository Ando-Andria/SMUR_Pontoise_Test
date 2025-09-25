<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Compte
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type:"integer")]
    private ?int $id = null;

    #[ORM\Column(type:"string", length:50)]
    private string $identifiant;

    #[ORM\Column(type:"string", length:255)]
    private string $mot_de_passe;

    #[ORM\Column(type:"datetime", nullable:true)]
    private ?\DateTimeInterface $derniere_connexion = null;

    #[ORM\OneToOne(mappedBy:"compte", targetEntity:Utilisateur::class)]
    private ?Utilisateur $utilisateur = null;

     public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }
    public function getMotDePasse(): string
    {
        return $this->mot_de_passe;
    }

    public function setMotDePasse(string $motDePasse): self
    {
        $this->mot_de_passe = $motDePasse;
        return $this;
    }

    public function getIdentifiant(): string
    {
        return $this->identifiant;
    }

    public function setIdentifiant(string $identifiant): self
    {
        $this->identifiant = $identifiant;
        return $this;
    }

    public function getDerniereConnexion(): ?\DateTimeInterface
    {
        return $this->derniere_connexion;
    }

    public function setDerniereConnexion(?\DateTimeInterface $date): self
    {
        $this->derniere_connexion = $date;
        return $this;
    }
    public function getUtilisateur(): ?Utilisateur
{
    return $this->utilisateur;
}

public function setUtilisateur(?Utilisateur $utilisateur): self
{
    $this->utilisateur = $utilisateur;
    return $this;
}

}
