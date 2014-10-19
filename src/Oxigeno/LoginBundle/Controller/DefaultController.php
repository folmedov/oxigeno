<?php

namespace Oxigeno\LoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function loginAction() {
        return $this->render('LoginBundle:Default:login.html.twig');
    }
}
