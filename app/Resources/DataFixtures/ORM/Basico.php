<?php

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Oxigeno\LoginBundle\Entity\UsuarioAdministrador;

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
    }
}