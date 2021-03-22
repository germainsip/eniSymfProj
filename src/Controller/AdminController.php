<?php

namespace App\Controller;

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
        $form=$this->createFormBuilder()
            ->add('nom', TextType::class)
            ->add('date',DateType::class)
            ->add('save',SubmitType::class,['label'=>'Insérer un produit'])
            ->getForm();

        if ($request->isMethod('post')){
            return new JsonResponse($request->request->all());
        }
        return $this->render('admin/create.html.twig',
        array('my_form'=>$form->createView())
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
