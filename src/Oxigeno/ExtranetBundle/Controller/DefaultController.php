<?php

namespace Oxigeno\ExtranetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Oxigeno\ExtranetBundle\Entity\Paciente;
use Oxigeno\ExtranetBundle\Entity\Util;
use Oxigeno\ExtranetBundle\Entity\Fotografia;
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
                
                $telefono1 = $persona->getTelefonos()->get(0);
                $telefono1->setPersona($persona);
                
                $telefono2 = $persona->getTelefonos()->get(1);
                $telefono2->setPersona($persona);
                
                $ficha_medica = $paciente->getFichaMedica();
                $paciente->setFichaMedica($ficha_medica);
                
                $fotografia = $persona->getFotografia();
                $fotografia->upload();
                
                $em->persist($paciente);
                $em->flush();
                
                $peticion->getSession()->setFlash('info', Util::MNS_PACIENTE_INGRESAR);
                
                return $this->redirect($this->generateUrl('extranet_paciente_listar'));
            }
        }

        return $this->render('ExtranetBundle:Paciente:nuevo.html.twig', array(
                    'formulario' => $formulario->createView(),
                    'avatar' => $paciente->getPersona()->getFotografia()->getPath(),
        ));
    }
    
    public function editarAction($id) {
        $em = $this->getDoctrine()->getManager();
        $peticion = $this->getRequest();
        
        $paciente = $em->getRepository('ExtranetBundle:Paciente')->findOneById($id);
//        $fotografia = $paciente->getPersona()->getFotografia();
//        print 'AQUI! '.$fotografia->getPath();
        
        $formulario = $this->createForm(new PacienteType(), $paciente);
        
        if ($peticion->getMethod() == 'POST') {
            $rut = $formulario->getData()->getPersona()->getRut();
            
            $formulario->bind($peticion);
            
            if ($formulario->isValid()) { 
                if (!$paciente->getPersona()->getRut()) {
                    $paciente->getPersona()->setRut($rut);
                }
                
                $fotografia = $formulario->getData()->getPersona()->getFotografia();
                if ($fotografia->getFile()) {
                    $fotografia->upload();
                }
                
                $em->flush();
                
                $peticion->getSession()->setFlash('info', Util::MNS_PACIENTE_EDITAR/*.$fotografia->getWebPath()*/);
                
                return $this->redirect($this->generateUrl('extranet_paciente_ver', array('id' => $paciente->getId())));
            }
        }        
        
        return $this->render('ExtranetBundle:Paciente:editar.html.twig', array(
                    'formulario' => $formulario->createView(),
                    'paciente' => $paciente->getId(),
                    'avatar' => $paciente->getPersona()->getFotografia()->getPath(),
        ));
    }
    
    public function verAction($id) {
        $em = $this->getDoctrine()->getManager();
        
        $paciente = $em->getRepository('ExtranetBundle:Paciente')->findOneById($id);
        
        $formulario = $this->createForm(new VerPacienteType(), $paciente);
        
        return $this->render('ExtranetBundle:Paciente:ver.html.twig', array(
                    'formulario' => $formulario->createView(),
                    'paciente' => $paciente->getId(),
                    'nomnbre_completo' => $paciente->getPersona(),
                    'avatar' => $paciente->getPersona()->getFotografia()->getPath(),
        ));
    }

}
