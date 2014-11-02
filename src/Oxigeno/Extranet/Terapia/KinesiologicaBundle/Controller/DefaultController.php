<?php

namespace Oxigeno\Extranet\Terapia\KinesiologicaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TerapiaKinesiologicaBundle:Default:index.html.twig', array('name' => $name));
    }
}
