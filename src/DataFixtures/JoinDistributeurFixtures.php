<?php


namespace App\DataFixtures;


use App\Entity\Distributeur;
use App\Entity\Produit;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class JoinDistributeurFixtures extends \Doctrine\Bundle\FixturesBundle\Fixture implements \Doctrine\Common\DataFixtures\FixtureInterface, \Symfony\Component\DependencyInjection\ContainerAwareInterface
{
    private $container;
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $repProduit=$em->getRepository(Produit::class);


        $desktop = new Distributeur;
        $desktop->setNom('Desktop');

        $logitech= new Distributeur;
        $logitech->setNom('Logitech');

        $hp=new Distributeur;
        $hp->setNom('HP');

        $epson = new Distributeur;
        $epson->setNom('Epson');

        $dell = new Distributeur;
        $dell->setNom('Dell');

        $acer = new Distributeur;
        $acer->setNom('Acer');

        // les jointures
        $produit=$repProduit->findOneBy(array('nom' =>'souris'));
        $produit->addDistributeur($hp);
        $produit->addDistributeur($logitech);
        $manager->persist($produit);

        $produit=$repProduit->findOneBy(array('nom' =>'écran'));
        $produit->addDistributeur($hp);
        $produit->addDistributeur($dell);
        $manager->persist($produit);

        $produit=$repProduit->findOneBy(array('nom' =>'claviers'));
        $produit->addDistributeur($hp);
        $produit->addDistributeur($logitech);
        $manager->persist($produit);

        $produit=$repProduit->findOneBy(array('nom' =>'ordinateurs'));
        $produit->addDistributeur($hp);
        $produit->addDistributeur($dell);
        $produit->addDistributeur($acer);
        $manager->persist($produit);

        $produit=$repProduit->findOneBy(array('nom' =>'cartouche encre'));
        $produit->addDistributeur($epson);
        $manager->persist($produit);

        $produit=$repProduit->findOneBy(array('nom' =>'imprimante'));
        $produit->addDistributeur($epson);
        $produit->addDistributeur($hp);
        $manager->persist($produit);

        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}