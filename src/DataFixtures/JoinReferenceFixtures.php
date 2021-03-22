<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;

use App\Entity\Produit;
use App\Entity\Reference;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;



class JoinReferenceFixtures extends Fixture implements FixtureInterface, ContainerAwareInterface
{
    private $container;



    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $repProduit=$em->getRepository(Produit::class);
        $listeProduits=$repProduit->findAll();

        foreach( $listeProduits as $monProduit ) {

            $reference = new Reference;

            $reference->setNumero(rand());

            $monProduit->setReference($reference);
            $manager->persist($monProduit);
            // pas besoin du persist($reference)


            $manager->persist($monProduit);
        }
        $manager->flush();
    }
}
