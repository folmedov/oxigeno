<?php

namespace Oxigeno\ExtranetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Oxigeno\ExtranetBundle\Entity\Persona;

/**
 * Paciente
 *
 * @ORM\Table(name="paciente")
 * @ORM\Entity(repositoryClass="Oxigeno\ExtranetBundle\Entity\PacienteRepository")
 */
class Paciente
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
     * @var \DateTime
     *
     * @Assert\Date()
     * @ORM\Column(name="fecha_ingreso", type="datetime")
     */
    private $fecha_ingreso;
    
    /**
     * @var Oxigeno\ExtranetBundle\Entity\Persona
     * 
     * @Assert\NotNull()
     * @Assert\Type(type="Oxigeno\ExtranetBundle\Entity\Persona")
     * @ORM\OneToOne(targetEntity="Oxigeno\ExtranetBundle\Entity\Persona", cascade={"persist", "merge"})
     */
    private $persona;
    
    public function __construct() {
        $this->persona = new Persona();
        $this->fecha_ingreso = new \DateTime('now');
    }


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
     * Set fecha_ingreso
     *
     * @param \DateTime $fechaIngreso
     * @return Paciente
     */
    public function setFechaIngreso($fechaIngreso)
    {
        $this->fecha_ingreso = $fechaIngreso;

        return $this;
    }

    /**
     * Get fecha_ingreso
     *
     * @return \DateTime 
     */
    public function getFechaIngreso()
    {
        return $this->fecha_ingreso;
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
     * @return \Oxigeno\ExtranetBundle\Entity\Paciente
     */
    function setPersona(Persona $persona) {
        $this->persona = $persona;
        return $this;
    }
    
}
