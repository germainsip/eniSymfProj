<?php

namespace App\Controller;

use App\Entity\Distributeur;
use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListeProduitsController extends AbstractController
{
    /**
     * @Route("/liste", name="liste")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $produitsrepository= $em->getRepository(Produit::class);
        $listeProduits = $produitsrepository->findAll();
        $lastProduit= $produitsrepository->getLastProduit();
        return $this->render('liste_produits/index.html.twig', [
            'listeproduits' => $listeProduits,
            'lastproduit' => $lastProduit
        ]);
    }

    /**
     * @Route ("/distrib",name="distributeur")
     */
    public function listedistributeur(): Response
{
        $em = $this ->getDoctrine()->getManager();
        $repositoryDistributeur= $em->getRepository(Distributeur::class);
        $distributeur= $repositoryDistributeur->findAll();

        return $this->render('liste_produits/distributeur.html.twig', array('distributeurs'=>$distributeur));
}
}
