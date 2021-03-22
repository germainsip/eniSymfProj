<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        $session->getFlashBag()->add('message','message informatif');
        $session->getFlashBag()->add('message','message complémentaire');
        $session->set('status', 'primary');

        return $this->render('test/index.html.twig');
    }
}
