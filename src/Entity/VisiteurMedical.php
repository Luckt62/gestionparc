<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
class VisiteurMedical
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 50)]
    private string $nom;

    #[ORM\Column(type: 'string', length: 50)]
    private string $prenom;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    private string $email;

    #[ORM\Column(type: 'string', length: 20)]
    private string $telephone;

    #[ORM\Column(type: 'string', length: 20)]
    private string $role;

    #[ORM\OneToMany(mappedBy: 'visiteur', targetEntity: Affectation::class)]
    private Collection $attributions;

    public function __construct()
    {
        $this->attributions = new ArrayCollection();
    }

    // GETTERS & SETTERS
    public function getId(): int 
    {
        return $this->id;
    }

    public function getNom(): string 
    {
        return $this->nom;
    }

    public function setNom(string $nom): self 
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): string 
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self 
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getEmail(): string 
    {
        return $this->email;
    }

    public function setEmail(string $email): self 
    {
        $this->email = $email;
        return $this;
    }

    public function getTelephone(): string 
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self 
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function getRole(): string 
    {
        return $this->role;
    }

    public function setRole(string $role): self 
    {
        $this->role = $role;
        return $this;
    }

    public function getAttributions(): Collection
    {
        return $this->attributions;
    }
}
