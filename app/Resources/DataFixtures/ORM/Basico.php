<?php

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Oxigeno\LoginBundle\Entity\UsuarioAdministrador;
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
        $usuarioAdmin = new UsuarioAdministrador();
        $usuarioAdmin->setNombre('folmedov');
        $usuarioAdmin->setPassword('1q2w3e');
        $usuarioAdmin->setEmail('f.olmedo.v@gmail.com');
        
        $manager->persist($usuarioAdmin);
        $manager->flush();
        
        // creo un paciente
        $paciente = new Paciente();
        $paciente->setFechaIngreso(new \DateTime('today'));
        
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
        $telefono2->setNumero('+56987790438');
        $telefono2->setPersona($persona);
        
        $paciente->setPersona($persona);
        
        $manager->persist($paciente);
        $manager->flush();
    }
}