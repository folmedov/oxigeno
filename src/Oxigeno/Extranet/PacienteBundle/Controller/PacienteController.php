<?php

namespace Oxigeno\Extranet\PacienteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Oxigeno\Extranet\PacienteBundle\Entity\Paciente;
use Oxigeno\Extranet\PacienteBundle\Entity\Util;
use Oxigeno\Extranet\PacienteBundle\Form\PacienteType;
use Oxigeno\Extranet\PacienteBundle\Form\VerPacienteType;

class PacienteController extends Controller
{
    public function listarAction() {
        $em = $this->getDoctrine()->getManager();
        
        $lista_pacientes = $em->getRepository('PacienteBundle:Paciente')->findPacientes();
        
        return $this->render('PacienteBundle:Paciente:listar.html.twig', array(
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
                
                return $this->redirect($this->generateUrl('paciente_listar'));
            }
        }

        return $this->render('PacienteBundle:Paciente:nuevo.html.twig', array(
                    'formulario' => $formulario->createView(),
                    'avatar' => $paciente->getPersona()->getFotografia()->getPath(),
        ));
    }
    
    public function editarAction($id) {
        $em = $this->getDoctrine()->getManager();
        $peticion = $this->getRequest();
        
        $paciente = $em->getRepository('PacienteBundle:Paciente')->findOneById($id);
        
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
                
                return $this->redirect($this->generateUrl('paciente_ver', array('id' => $paciente->getId())));
            }
        }        
        
        return $this->render('PacienteBundle:Paciente:editar.html.twig', array(
                    'formulario' => $formulario->createView(),
                    'paciente' => $paciente->getId(),
                    'avatar' => $paciente->getPersona()->getFotografia()->getPath(),
        ));
    }
    
    public function verAction($id) {
        $em = $this->getDoctrine()->getManager();
        
        $paciente = $em->getRepository('PacienteBundle:Paciente')->findOneById($id);
        
        $formulario = $this->createForm(new VerPacienteType(), $paciente);
        
        return $this->render('PacienteBundle:Paciente:ver.html.twig', array(
                    'formulario' => $formulario->createView(),
                    'paciente' => $paciente->getId(),
                    'nomnbre_completo' => $paciente->getPersona(),
                    'avatar' => $paciente->getPersona()->getFotografia()->getPath(),
        ));
    }
}