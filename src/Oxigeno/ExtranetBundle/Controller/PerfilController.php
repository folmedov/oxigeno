<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Oxigeno\ExtranetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Oxigeno\ExtranetBundle\Entity\Persona;
use Oxigeno\LoginBundle\Form\UsuarioType;

/**
 * Description of PerfilController
 *
 * @author francisco
 */
class PerfilController extends Controller {
    
    public function editarAction() {
        $usuario = $this->getUser();
        $peticion = $this->getRequest();
        
        if (!$usuario->getPersona()) {
            $usuario->setPersona(new Persona());
            $usuario->getPersona()->setEmail($usuario->getEmail());
        }
        
        $formulario = $this->createForm(new UsuarioType(), $usuario);
        
        if ($peticion->getMethod() == 'POST') {
            $formulario->bind($peticion);
            $em = $this->getDoctrine()->getManager();
            
//            $persona = $formulario->getData()->getPersona();
            $rut = $formulario->getData()->getPersona()->getRut();
            $persona = $em->getRepository('ExtranetBundle:Persona')->findOneByRut($rut);
                
            if ($persona) {
                $usuario->setPersona($persona);
            }
            
            if ($formulario->isValid()) {
                $em->persist($usuario);
                $em->flush();
                
            }
        }
        
        return $this->render('ExtranetBundle:Perfil:editar.html.twig', array(
            'usuario' => $usuario,
            'formulario' => $formulario->createView(),
        ));
    }
    
}
