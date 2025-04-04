<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Affectation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'date')]
    private \DateTime $date_debut;

    #[ORM\Column(type: 'date')]
    private \DateTime $date_fin;

    #[ORM\ManyToOne(targetEntity: Vehicule::class, inversedBy: 'attributions')]
    #[ORM\JoinColumn(nullable: false)]
    private Vehicule $vehicule;

    #[ORM\ManyToOne(targetEntity: VisiteurMedical::class, inversedBy: 'attributions')]
    #[ORM\JoinColumn(nullable: false)]
    private VisiteurMedical $visiteur;
    
    public function getId(): int 
    {
        return $this->id;
    }

    public function getDateDebut(): \DateTime 
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTime $date_debut): self 
    {
        $this->date_debut = $date_debut;
        return $this;
    }

    public function getDateFin(): \DateTime 
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTime $date_fin): self 
    {
        $this->date_fin = $date_fin;
        return $this;
    }

    public function getVehicule(): Vehicule 
    {
        return $this->vehicule;
    }

    public function setVehicule(Vehicule $vehicule): self 
    {
        $this->vehicule = $vehicule;
        return $this;
    }

    public function getVisiteur(): VisiteurMedical 
    {
        return $this->visiteur;
    }

    public function setVisiteur(VisiteurMedical $visiteur): self 
    {
        $this->visiteur = $visiteur;
        return $this;
    }
}
