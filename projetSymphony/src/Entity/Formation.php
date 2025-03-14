<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormationRepository::class)]
class Formation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column]
    private ?int $nbreHeures = null;

    #[ORM\Column(length: 255)]
    private ?string $departement = null;

    #[ORM\ManyToOne(targetEntity:Produit::class)]
    #[ORM\JoinColumn(nullable:true)]
    private $produit = null;

    #[ORM\Column]
    private ?int $inscriptionMax = null;  

    #[ORM\Column]
    private int $nbInscription = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getNbreHeures(): ?int
    {
        return $this->nbreHeures;
    }

    public function setNbreHeures(int $nbreHeures): static
    {
        $this->nbreHeures = $nbreHeures;

        return $this;
    }

    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    public function setDepartement(string $departement): static
    {
        $this->departement = $departement;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): static
    {
        $this->produit = $produit;

        return $this;
    }

    public function getInscriptionMax(): ?int
    {
        return $this->inscriptionMax;
    }

    public function setInscriptionMax(int $inscriptionMax): static
    {
        $this->inscriptionMax = $inscriptionMax;
        
        return $this;
    }

    public function getNbInscription(): int
    {
        return $this->nbInscription;
    }

    public function setNbInscription(int $nbInscription): static
    {
        $this->nbInscription = $nbInscription;

        return $this;
    }

}
