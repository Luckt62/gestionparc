<?php
namespace App\Entity;

use App\Repository\VehiculeRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: VehiculeRepository::class)]
class Vehicule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null; // 👈 Doit être nullable

    #[ORM\Column(type: 'string', length: 50)]
    private string $marque;

    #[ORM\Column(type: 'string', length: 50)]
    private string $modele;

    #[ORM\Column(type: 'string', length: 15, unique: true)]
    private string $immatriculation;

    #[ORM\Column(type: 'integer')]
    private int $kilometrage;

    #[ORM\Column(type: 'string', length: 20)]
    private string $statut;

    #[ORM\OneToMany(mappedBy: 'vehicule', targetEntity: Affectation::class, cascade: ['persist', 'remove'])]
    private Collection $attributions;

    #[ORM\OneToMany(mappedBy: 'vehicule', targetEntity: Entretien::class, cascade: ['persist', 'remove'])]
    private Collection $entretiens;

    public function __construct()
    {
        $this->attributions = new ArrayCollection();
        $this->entretiens = new ArrayCollection();
    }

    // GETTERS & SETTERS
    public function getId(): ?int { return $this->id; }
    public function getMarque(): string { return $this->marque; }
    public function setMarque(string $marque): self { $this->marque = $marque; return $this; }
    public function getModele(): string { return $this->modele; }
    public function setModele(string $modele): self { $this->modele = $modele; return $this; }
    public function getImmatriculation(): string { return $this->immatriculation; }
    public function setImmatriculation(string $immatriculation): self { $this->immatriculation = $immatriculation; return $this; }
    public function getKilometrage(): int { return $this->kilometrage; }
    public function setKilometrage(int $kilometrage): self { $this->kilometrage = $kilometrage; return $this; }
    public function getStatut(): string { return $this->statut; }
    public function setStatut(string $statut): self { $this->statut = $statut; return $this; }

    // Relations avec Affectation
    public function getAttributions(): Collection { return $this->attributions; }
    public function addAttribution(Affectation $affectation): self
    {
        if (!$this->attributions->contains($affectation)) {
            $this->attributions->add($affectation);
            $affectation->setVehicule($this);
        }
        return $this;
    }
    public function removeAttribution(Affectation $affectation): self
    {
        if ($this->attributions->removeElement($affectation)) {
            if ($affectation->getVehicule() === $this) {
                $affectation->setVehicule(null);
            }
        }
        return $this;
    }

    // Relations avec Entretien
    public function getEntretiens(): Collection { return $this->entretiens; }
    public function addEntretien(Entretien $entretien): self
    {
        if (!$this->entretiens->contains($entretien)) {
            $this->entretiens->add($entretien);
            $entretien->setVehicule($this);
        }
        return $this;
    }
    public function removeEntretien(Entretien $entretien): self
    {
        if ($this->entretiens->removeElement($entretien)) {
            if ($entretien->getVehicule() === $this) {
                $entretien->setVehicule(null);
            }
        }
        return $this;
    }
}
