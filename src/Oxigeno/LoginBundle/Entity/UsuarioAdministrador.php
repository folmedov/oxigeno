<?php

namespace Oxigeno\LoginBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsuarioAdministrador
 *
 * @ORM\Table(name="usuario_administrador")
 * @ORM\Entity
 */
class UsuarioAdministrador extends Usuario {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    public function getRoles() {
        
    }

}
