<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Entretien
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 50)]
    private string $type;

    #[ORM\Column(type: 'date')]
    private \DateTime $date;

    #[ORM\Column(type: 'float')]
    private float $cout;

    // Le champ piece_jointe devient un champ de type BLOB pour stocker le fichier dans la base de données
    #[ORM\Column(type: 'blob', nullable: true)]
    private ?string $piece_jointe;

    #[ORM\ManyToOne(targetEntity: Vehicule::class, inversedBy: 'entretiens')]
    #[ORM\JoinColumn(nullable: false)]
    private Vehicule $vehicule;

    // GETTERS & SETTERS
    public function getId(): int { return $this->id; }
    public function getType(): string { return $this->type; }
    public function setType(string $type): self { $this->type = $type; return $this; }
    public function getDate(): \DateTime { return $this->date; }
    public function setDate(\DateTime $date): self { $this->date = $date; return $this; }
    public function getCout(): float { return $this->cout; }
    public function setCout(float $cout): self { $this->cout = $cout; return $this; }
    public function getPieceJointe(): ?string { return $this->piece_jointe; }
    public function setPieceJointe(?string $piece_jointe): self { $this->piece_jointe = $piece_jointe; return $this; }
    public function getVehicule(): Vehicule { return $this->vehicule; }
    public function setVehicule(Vehicule $vehicule): self { $this->vehicule = $vehicule; return $this; }
}
