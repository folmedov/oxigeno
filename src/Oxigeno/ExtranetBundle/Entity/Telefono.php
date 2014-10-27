<?php

namespace Oxigeno\ExtranetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Oxigeno\ExtranetBundle\Entity\Persona;

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
     * @var Oxigeno\ExtranetBundle\Entity\Persona
     * 
     * @ORM\ManyToOne(targetEntity="Oxigeno\ExtranetBundle\Entity\Persona", inversedBy="telefonos")
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
     * @return Oxigeno\ExtranetBundle\Entity\Persona
     */
    function getPersona() {
        return $this->persona;
    }

    /**
     * Set persona
     * 
     * @param \Oxigeno\ExtranetBundle\Entity\Persona $persona
     * @return \Oxigeno\ExtranetBundle\Entity\Telefono
     */
    function setPersona(Persona $persona) {
        $this->persona = $persona;
        return $this;
    }

}
