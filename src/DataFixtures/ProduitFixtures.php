<?php
namespace App\DataFixtures;

use App\Data\ListeProduits;
use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProduitFixtures extends Fixture{

    public function load(ObjectManager $manager)
    {

        foreach (ListeProduits::$mesProduits as $monProduit) {
            $produit= new Produit();
            $produit
                ->setNom($monProduit['nom'])
                ->setPrix($monProduit['prix'])
                ->setQuantite($monProduit['quantite'])
                ->setRupture($monProduit['rupture']);
            $manager->persist($produit);
        }
        $manager->flush();

        $manager->flush();
    }
}