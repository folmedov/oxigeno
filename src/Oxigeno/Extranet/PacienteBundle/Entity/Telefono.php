<?php

namespace Oxigeno\Extranet\PacienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Oxigeno\Extranet\PacienteBundle\Entity\Persona;

/**
 * Telefono
 *
 * @ORM\Table(name="telefono")
 * @ORM\Entity
 */
class Telefono {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=12)
     */
    private $numero;

    /**
     * @var Oxigeno\Extranet\PacienteBundle\Entity\Persona
     * 
     * @ORM\ManyToOne(targetEntity="Oxigeno\Extranet\PacienteBundle\Entity\Persona", inversedBy="telefonos")
     */
    private $persona;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set numero
     *
     * @param string $numero
     * @return Telefono
     */
    public function setNumero($numero) {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string 
     */
    public function getNumero() {
        return $this->numero;
    }

    /**
     * Get persona
     * 
     * @return Oxigeno\Extranet\PacienteBundle\Entity\Persona
     */
    function getPersona() {
        return $this->persona;
    }

    /**
     * Set persona
     * 
     * @param \Oxigeno\Extranet\PacienteBundle\Entity\Persona $persona
     * @return \Oxigeno\Extranet\PacienteBundle\Entity\Telefono
     */
    function setPersona(Persona $persona) {
        $this->persona = $persona;
        return $this;
    }

}
