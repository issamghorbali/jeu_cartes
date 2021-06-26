<?php

namespace App\Entity;

use App\Repository\CarteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarteRepository::class)
 */
class Carte
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Couleur::class, inversedBy="cartes")
     */
    private $couleur;

    /**
     * @ORM\ManyToOne(targetEntity=Valeur::class, inversedBy="cartes")
     */
    private $valeur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCouleur(): ?Couleur
    {
        return $this->couleur;
    }

    public function setCouleur(?Couleur $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getValeur(): ?Valeur
    {
        return $this->valeur;
    }

    public function setValeur(?Valeur $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }
    //recuperer la force d'une carte
    public function getForce()
    {
        return ($this->couleur->getOrdre()).str_pad($this->valeur->getOrdre(),2,"0",STR_PAD_LEFT);
    }
}
