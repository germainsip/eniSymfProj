<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/insert", name="insert")
     * @param Request $request
     * @return Response
     */
    public function insert(Request $request): Response
    {
        $produit = new Produit();
        $formProduit = $this->createForm(ProduitType::class, $produit);
        $formProduit->add('creer', SubmitType::class, array('label' => 'Insertion d\'un produit'));
        $formProduit->handleRequest($request);

        if ($request->isMethod('post') && $formProduit->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $file = $formProduit['lienImage']->getData();

            if (!is_string($file)) {
                $filename = $file->getClientOriginalName();
                $file->move(
                    $this->getParameter('images_directory'),
                    $filename);
                $produit->setLienImage($filename);
            } else {
                $session = $request->getSession();
                $session->getFlashBag()->add('message', 'Vous devez choisir une image pour le produit');
                $session->set('statut', 'danger');
                return $this->redirect($this->generateUrl('insert'));
            }
            $em->persist($produit);
            $em->flush();
            $session = $request->getSession();
            $session->getFlashBag()->add('message', 'Un nouveau produit a été ajouté');
            $session->set('status', 'success');
            return $this->redirect($this->generateUrl('liste'));


        }
        return $this->render('admin/create.html.twig',
            array('my_form' => $formProduit->createView())
        );
    }

    /**
     * @Route("/update/{id}", name="update")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function update(Request $request, $id): Response
    {
        $em=$this->getDoctrine()->getManager();
        $produitRepository=$em->getRepository(Produit::class);
        $produit=$produitRepository->find($id);

        $img=$produit->getLienImage();


        $formProduit= $this->createForm(ProduitType::class,$produit);

        // ajoute un bouton submit

        $formProduit->add('creer', SubmitType::class,array(
            'label'=>'Valider',
            'validation_groups'=>array('all')
        ));
        $formProduit->handleRequest($request);

        if($request->isMethod('post') && $formProduit->isValid() ){

            // insertion dans la base

            $file = $formProduit['lienImage']->getData();

            if(!is_string($file)){

                $filename=$file->getClientOriginalName();
                $file->move(
                    $this->getParameter('images_directory'),
                    $filename
                );
                $produit->setLienImage($filename);
            } else {

                $produit->setLienImage($img);
            }
            $em->persist($produit);
            $em->flush();
            $session=$request->getSession();
            $session->getFlashBag()->add('message','le produit a été mis à jour');
            $session->set('statut','success');
            return $this->redirect($this->generateUrl('liste'));
        }
        return $this->render('admin/create.html.twig',
            array('my_form'=>$formProduit->createView()));
    }

    /**
     * @Route("/delete/{id}", name="delete")
     * @param Request $request
     * @param $id
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function delete(Request $request, $id, EntityManagerInterface $em): Response
    {
        $produitRepository=$em->getRepository(Produit::class);

        $produit = $produitRepository->find($id);
        //dd($produit);
        $em->remove($produit);
        $em->flush();
        unlink($this->getParameter('images_directory').$produit->getLienImage());
        $session = $request->getSession();
        $session->getFlashBag()->add('message','le produit a été supprimé');
        $session->set('statut','success');
        return $this->redirect($this->generateUrl('liste'));
    }
}
