<?php

namespace Oxigeno\ExtranetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function listarAction()
    {
        return $this->render('ExtranetBundle:Default:listar.html.twig');
    }
}
