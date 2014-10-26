<?php

namespace Oxigeno\ExtranetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Oxigeno\ExtranetBundle\Entity\Paciente;
use Oxigeno\ExtranetBundle\Entity\Persona;
use Oxigeno\ExtranetBundle\Entity\Direccion;
use Oxigeno\ExtranetBundle\Entity\Telefono;
use Doctrine\Common\Collections\ArrayCollection;
use Oxigeno\ExtranetBundle\Form\PacienteType;
use Oxigeno\ExtranetBundle\Form\PersonaType;

class DefaultController extends Controller {

    public function listarAction() {
        $em = $this->getDoctrine()->getManager();
        
        $lista_pacientes = $em->getRepository('ExtranetBundle:Paciente')->findPacientes();
        
        return $this->render('ExtranetBundle:Default:listar.html.twig', array(
            'pacientes' => $lista_pacientes,
        ));
    }

    public function nuevoAction() {
        $peticion = $this->getRequest();
        $paciente = new Paciente();
        //$persona = new Persona();
        
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
                
                $peticion->getSession()->setFlash('info', 'Se registro el paciente correctamente');
                
                return $this->redirect($this->generateUrl('extranet_paciente_listar'));
            }
        }

        return $this->render('ExtranetBundle:Default:nuevo.html.twig', array(
                    'formulario' => $formulario->createView(),
        ));
    }

}
