<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
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
       $formProduit = $this->createForm(ProduitType::class,$produit);
       $formProduit->add('creer',SubmitType::class,array('label'=>'Insertion d\'un produit'));
       if($request->isMethod('post')){
           return new JsonResponse($request->request->all()
           );
       }
        return $this->render('admin/create.html.twig',
        array('my_form'=>$formProduit->createView())
        );
    }

    /**
     * @Route("/update/{id}", name="update")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function update(Request $request,$id): Response
    {
        return $this->render('admin/create.html.twig');
    }

    /**
     * @Route("/delete/{id}", name="delete")
     * @param Request $request
     * @param $id
     */
    public function delete(Request $request,$id)
    {
    }
}
