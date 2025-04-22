<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

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

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $pieceJointe = null;

    #[ORM\ManyToOne(targetEntity: Vehicule::class, inversedBy: 'entretiens')]
    #[ORM\JoinColumn(nullable: false)]
    private Vehicule $vehicule;

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getCout(): float
    {
        return $this->cout;
    }

    public function setCout(float $cout): self
    {
        $this->cout = $cout;
        return $this;
    }

    public function getPieceJointe(): ?string
    {
        return $this->pieceJointe;
    }

    public function setPieceJointe(?string $pieceJointe): self
    {
        $this->pieceJointe = $pieceJointe;
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
}
