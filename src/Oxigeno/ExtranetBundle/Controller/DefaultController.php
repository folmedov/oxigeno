<?php

namespace Oxigeno\ExtranetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Oxigeno\ExtranetBundle\Entity\Paciente;
use Oxigeno\ExtranetBundle\Entity\Util;
use Oxigeno\ExtranetBundle\Form\PacienteType;
use Oxigeno\ExtranetBundle\Form\VerPacienteType;

class DefaultController extends Controller {

    public function listarAction() {
        $em = $this->getDoctrine()->getManager();
        
        $lista_pacientes = $em->getRepository('ExtranetBundle:Paciente')->findPacientes();
        
        return $this->render('ExtranetBundle:Paciente:listar.html.twig', array(
            'pacientes' => $lista_pacientes,
        ));
    }

    public function nuevoAction() {
        $peticion = $this->getRequest();
        $paciente = new Paciente();
        
        $formulario = $this->createForm(new PacienteType(), $paciente);
        
        if ($peticion->getMethod() == 'POST') {
            $formulario->bind($peticion);
            
            if ($formulario->isValid()) {
                $em = $this->getDoctrine()->getManager();
                
                $persona = $paciente->getPersona();
                $direccion = $persona->getDireccion();
                $direccion->setPersona($persona);
                
                $telefono1 = $persona->getTelefonos()->get('telefono_personal');
                $telefono1->setPersona($persona);
                
                $telefono2 = $persona->getTelefonos()->get('telefono_de_contacto');
                $telefono2->setPersona($persona);
                
                $em->persist($paciente);
                $em->flush();
                
                $peticion->getSession()->setFlash('info', Util::MNS_PACIENTE_INGRESAR);
                
                return $this->redirect($this->generateUrl('extranet_paciente_listar'));
            }
        }

        return $this->render('ExtranetBundle:Paciente:nuevo.html.twig', array(
                    'formulario' => $formulario->createView(),
        ));
    }
    
    public function editarAction($id) {
        $em = $this->getDoctrine()->getManager();
        $peticion = $this->getRequest();
        
        $paciente = $em->getRepository('ExtranetBundle:Paciente')->findOneById($id);
        
        $formulario = $this->createForm(new PacienteType(), $paciente);
        
        if ($peticion->getMethod() == 'POST') {
            $rut = $formulario->getData()->getPersona()->getRut();
            
            $formulario->bind($peticion);
            
            if ($formulario->isValid()) { 
                if (!$paciente->getPersona()->getRut()) {
                    $paciente->getPersona()->setRut($rut);
                }
                
                $em->flush();
                
                $peticion->getSession()->setFlash('info', Util::MNS_PACIENTE_EDITAR);
                
                return $this->redirect($this->generateUrl('extranet_paciente_listar'));
            }
        }
        
        return $this->render('ExtranetBundle:Paciente:editar.html.twig', array(
                    'formulario' => $formulario->createView(),
                    'paciente' => $paciente->getId(),
        ));
    }
    
    public function verAction($id) {
        $em = $this->getDoctrine()->getManager();
        
        $paciente = $em->getRepository('ExtranetBundle:Paciente')->findOneById($id);
        
        $formulario = $this->createForm(new VerPacienteType(), $paciente);
        
        return $this->render('ExtranetBundle:Paciente:ver.html.twig', array(
                    'formulario' => $formulario->createView(),
                    'paciente' => $paciente->getId(),
        ));
    }

}
