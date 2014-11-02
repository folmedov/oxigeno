<?php

namespace Oxigeno\Extranet\SecretariaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SecretariaBundle:Default:index.html.twig', array('name' => $name));
    }
}
