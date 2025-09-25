<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

#[ORM\Entity]
#[ORM\Table(name: "pin")]
class Pin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private ?int $id = null;

    #[ORM\Column(type:"string", length:6)]
    private string $pin;

    #[ORM\Column(type:"datetime_immutable")]
    private DateTimeImmutable $dateExpiration;

    #[ORM\ManyToOne(targetEntity: "App\Entity\Compte")]
    #[ORM\JoinColumn(nullable: false, onDelete:"CASCADE")]
    private \App\Entity\Compte $compte;

    public function getId(): ?int { return $this->id; }
    public function getPin(): string { return $this->pin; }
    public function setPin(string $pin): self { $this->pin = $pin; return $this; }
    public function getDateExpiration(): DateTimeImmutable { return $this->dateExpiration; }
    public function setDateExpiration(DateTimeImmutable $dateExpiration): self { $this->dateExpiration = $dateExpiration; return $this; }
    public function getCompte(): \App\Entity\Compte { return $this->compte; }
    public function setCompte(\App\Entity\Compte $compte): self { $this->compte = $compte; return $this; }
}
