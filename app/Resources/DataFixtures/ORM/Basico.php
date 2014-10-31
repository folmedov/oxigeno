<?php

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Oxigeno\LoginBundle\Entity\Administrador;
use Oxigeno\ExtranetBundle\Entity\Paciente;

class Basico implements FixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager) {
        // creo un usuario de tipo administrador
        $usuarioAdmin = new Administrador();
        $usuarioAdmin->setNombre('admin');
        
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($usuarioAdmin);
        $salt = md5(time());
        $password = $encoder->encodePassword('1q2w3e', $salt);
        $usuarioAdmin->setPassword($password);
        $usuarioAdmin->setSalt($salt);
        $usuarioAdmin->setEmail('folmedov@yahoo.cl');
        
        $manager->persist($usuarioAdmin);
        $manager->flush();
        
        // creo un paciente
        $paciente = new Paciente();
        $paciente->setFechaIngreso(new \DateTime('today'));
        
        $ficha_medica = $paciente->getFichaMedica();
        $ficha_medica->setDiagnostico('Lorem ipsum dolor sit amet, consectetur '
                . 'adipiscing elit, sed do eiusmod tempor incididunt ut labore '
                . 'et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud '
                . 'exercitation ullamco laboris nisi ut aliquip ex ea commodo '
                . 'consequat. Duis aute irure dolor in reprehenderit in voluptate '
                . 'velit esse cillum dolore eu fugiat nulla pariatur. '
                . 'Excepteur sint occaecat cupidatat non proident, sunt in '
                . 'culpa qui officia deserunt mollit anim id est laborum');
        
        $persona = $paciente->getPersona();
        $persona->setNombre('Francisco');
        $persona->setApellido('Olmedo Valencia');
        $persona->setRut('163015048');
        $persona->setFechaNacimiento(new \DateTime('1986-04-19'));
        $persona->setEmail('f.olmedo.v@gmail.com');
        
        $direccion = $persona->getDireccion();
        $direccion->setDireccion('Manuel Bulnes 756');
        $direccion->setPersona($persona);
        
        $telefono1 = $persona->getTelefonos()->get(0);
        $telefono1->setNumero('+56987790438');
        $telefono1->setPersona($persona);
          
        $telefono2 = $persona->getTelefonos()->get(1);
        $telefono2->setNumero('+56322319059');
        $telefono2->setPersona($persona);
        
        $paciente->setPersona($persona);
        
        $manager->persist($paciente);
        $manager->flush();
    }
}