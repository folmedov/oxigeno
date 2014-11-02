<?php

namespace Oxigeno\Extranet\Terapia\HiperbaricaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TerapiaHiperbaricaBundle:Default:index.html.twig', array('name' => $name));
    }
}
