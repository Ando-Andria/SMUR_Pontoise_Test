<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
class Utilisateur
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type:"integer")]
    private ?int $id = null;

    #[ORM\Column(type:"string", length:255, nullable:true)]
    private ?string $nom = null;

    #[ORM\Column(type:"string", length:255, nullable:true)]
    private ?string $prenom = null;

    #[ORM\Column(type:"string", length:255, unique:true, nullable:true)]
    private ?string $mailPerso = null;

    #[ORM\Column(type:"string", length:255, unique:true, nullable:true)]
    private ?string $mailPro = null;

    #[ORM\Column(type:"string", length:15, nullable:true)]
    private ?string $telephone = null;

    #[ORM\OneToOne(inversedBy:"utilisateur", targetEntity:Compte::class)]
    #[ORM\JoinColumn(nullable:false)]
    private Compte $compte;

    #[ORM\ManyToMany(targetEntity:Fonction::class)]
    #[ORM\JoinTable(name:"utilisateur_fonction")]
    private Collection $fonctions;

    #[ORM\ManyToMany(targetEntity:Metier::class)]
    #[ORM\JoinTable(name:"utilisateur_metier")]
    private Collection $metiers;

    #[ORM\ManyToMany(targetEntity:Bureau::class)]
    #[ORM\JoinTable(name:"utilisateur_bureau")]
    private Collection $bureaux;

    #[ORM\ManyToMany(targetEntity:Module::class)]
    #[ORM\JoinTable(name:"utilisateur_module")]
    private Collection $modules;

    public function __construct()
    {
        $this->fonctions = new ArrayCollection();
        $this->metiers = new ArrayCollection();
        $this->bureaux = new ArrayCollection();
        $this->modules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getMailPerso(): ?string
    {
        return $this->mailPerso;
    }

    public function setMailPerso(?string $mailPerso): self
    {
        $this->mailPerso = $mailPerso;
        return $this;
    }

    public function getMailPro(): ?string
    {
        return $this->mailPro;
    }

    public function setMailPro(?string $mailPro): self
    {
        $this->mailPro = $mailPro;
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function getCompte(): Compte
    {
        return $this->compte;
    }

    public function setCompte(Compte $compte): self
    {
        $this->compte = $compte;
        return $this;
    }

    // Fonctions
    public function getFonctions(): Collection
    {
        return $this->fonctions;
    }

    public function addFonction(Fonction $fonction): self
    {
        if (!$this->fonctions->contains($fonction)) {
            $this->fonctions->add($fonction);
        }
        return $this;
    }

    public function removeFonction(Fonction $fonction): self
    {
        $this->fonctions->removeElement($fonction);
        return $this;
    }

    // Metiers
    public function getMetiers(): Collection
    {
        return $this->metiers;
    }

    public function addMetier(Metier $metier): self
    {
        if (!$this->metiers->contains($metier)) {
            $this->metiers->add($metier);
        }
        return $this;
    }

    public function removeMetier(Metier $metier): self
    {
        $this->metiers->removeElement($metier);
        return $this;
    }

    // Bureaux
    public function getBureaux(): Collection
    {
        return $this->bureaux;
    }

    public function addBureau(Bureau $bureau): self
    {
        if (!$this->bureaux->contains($bureau)) {
            $this->bureaux->add($bureau);
        }
        return $this;
    }

    public function removeBureau(Bureau $bureau): self
    {
        $this->bureaux->removeElement($bureau);
        return $this;
    }

    // Modules
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(Module $module): self
    {
        if (!$this->modules->contains($module)) {
            $this->modules->add($module);
        }
        return $this;
    }

    public function removeModule(Module $module): self
    {
        $this->modules->removeElement($module);
        return $this;
    }
}
