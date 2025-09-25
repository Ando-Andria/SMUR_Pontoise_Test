<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "token_compte")]
class TokenCompte
{
    #[ORM\Id]
    #[ORM\Column(type: "string", length: 255)]
    private ?string $id = null;

    #[ORM\Column(type: "string", length: 255)]
    private ?string $valeur = null;

    #[ORM\Column(type: "integer")]
    private ?int $idCompte = null;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $date_expiration = null;


    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getValeur(): ?string
    {
        return $this->valeur;
    }

    public function setValeur(string $valeur): self
    {
        $this->valeur = $valeur;
        return $this;
    }

    public function getIdCompte(): ?int
    {
        return $this->idCompte;
    }

    public function setIdCompte(int $idCompte): self
    {
        $this->idCompte = $idCompte;
        return $this;
    }

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->date_expiration;
    }

    public function setDateExpiration(\DateTimeInterface $date_expiration): self
    {
        $this->date_expiration = $date_expiration;
        return $this;
    }
}
