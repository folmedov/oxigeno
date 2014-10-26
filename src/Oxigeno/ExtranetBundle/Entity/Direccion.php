<?php

namespace Oxigeno\ExtranetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Oxigeno\ExtranetBundle\Entity\Persona;

/**
 * Direccion
 *
 * @ORM\Table(name="direccion")
 * @ORM\Entity
 */
class Direccion
{
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
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;

    /**
     * @var float
     *
     * @ORM\Column(name="lat", type="float", nullable=true)
     */
    private $lat;

    /**
     * @var float
     *
     * @ORM\Column(name="lng", type="float", nullable=true)
     */
    private $lng;
    
    /**
     * @var Oxigeno\ExtranetBundle\Entity\Persona
     * 
     * @ORM\OneToOne(targetEntity="Oxigeno\ExtranetBundle\Entity\Persona", inversedBy="direccion")
     */
    private $persona;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Direccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set lat
     *
     * @param float $lat
     * @return Direccion
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return float 
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lng
     *
     * @param float $lng
     * @return Direccion
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get lng
     *
     * @return float 
     */
    public function getLng()
    {
        return $this->lng;
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
     * @return \Oxigeno\LoginBundle\Entity\Usuario
     */
    function setPersona(Persona $persona) {
        $this->persona = $persona;
        return $this;
    }
    
    public function __toString() {
        return $this->getDireccion();
    }
}
