<?php

namespace App\Entity;

use App\Repository\ReferenceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReferenceRepository::class)
 */
class Reference
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numero;

    /**
     * @ORM\OneToOne(targetEntity=Produit::class, mappedBy="reference", cascade={"persist", "remove"})
     */
    private $produit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        // unset the owning side of the relation if necessary
        if ($produit === null && $this->produit !== null) {
            $this->produit->setReference(null);
        }

        // set the owning side of the relation if necessary
        if ($produit !== null && $produit->getReference() !== $this) {
            $produit->setReference($this);
        }

        $this->produit = $produit;

        return $this;
    }
}
