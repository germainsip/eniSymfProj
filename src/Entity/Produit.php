<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $nom;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\Column(type="boolean")
     */
    private $rupture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lienImage;

    /**
     * @ORM\OneToOne(targetEntity=Reference::class, inversedBy="produit", cascade={"persist", "remove"})
     */
    private $reference;

    /**
     * @ORM\ManyToMany(targetEntity=Distributeur::class, mappedBy="produits",cascade="persist")
     * @ORM\JoinColumn(nullable=true)
     */
    private $distributeurs;

    public function __construct()
    {
        $this->distributeurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getRupture(): ?bool
    {
        return $this->rupture;
    }

    public function setRupture(bool $rupture): self
    {
        $this->rupture = $rupture;

        return $this;
    }

    public function getLienImage(): ?string
    {
        return $this->lienImage;
    }

    public function setLienImage(?string $lienImage): self
    {
        $this->lienImage = $lienImage;

        return $this;
    }

    public function getReference(): ?Reference
    {
        return $this->reference;
    }

    public function setReference(?Reference $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return Collection|Distributeur[]
     */
    public function getDistributeurs(): Collection
    {
        return $this->distributeurs;
    }

    public function addDistributeur(Distributeur $distributeur): self
    {
        if (!$this->distributeurs->contains($distributeur)) {
            $this->distributeurs[] = $distributeur;
            $distributeur->addProduit($this);
        }

        return $this;
    }

    public function removeDistributeur(Distributeur $distributeur): self
    {
        if ($this->distributeurs->removeElement($distributeur)) {
            $distributeur->removeProduit($this);
        }

        return $this;
    }
}
