<?php

namespace Oxigeno\Extranet\SeguridadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsuarioAdministrador
 *
 * @ORM\Table(name="administrador")
 * @ORM\Entity
 */
class Administrador extends Usuario {

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
        return array('ROLE_ADMINISTRADOR');
    }

}
