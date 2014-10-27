<?php

namespace Oxigeno\ExtranetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Oxigeno\ExtranetBundle\Entity\Persona;
use Oxigeno\ExtranetBundle\Entity\FichaMedica;

/**
 * Paciente
 *
 * @ORM\Table(name="paciente")
 * @ORM\Entity(repositoryClass="Oxigeno\ExtranetBundle\Entity\Repository\PacienteRepository")
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
     * @ORM\OneToOne(targetEntity="Oxigeno\ExtranetBundle\Entity\Persona", cascade={"persist"})
     */
    private $persona;
    
    /**
     * @var Oxigeno\ExtranetBundle\Entity\FichaMedica
     * 
     * @ORM\OneToOne(targetEntity="Oxigeno\ExtranetBundle\Entity\FichaMedica", cascade={"persist"})
     */
    private $ficha_medica;


    public function __construct() {
        $this->persona = new Persona();
        $this->ficha_medica = new FichaMedica();
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
    public function getPersona() {
        return $this->persona;
    }
    
    /**
     * Set persona
     * 
     * @param \Oxigeno\ExtranetBundle\Entity\Persona $persona
     * @return \Oxigeno\ExtranetBundle\Entity\Paciente
     */
    public function setPersona(Persona $persona) {
        $this->persona = $persona;
        return $this;
    }
    
    /**
     * Set ficha_medica
     * 
     * @return Oxigeno\ExtranetBundle\Entity\FichaMedica
     */
    public function getFichaMedica() {
        return $this->ficha_medica;
    }
    
    /**
     * Get ficha_medica
     * 
     * @param \Oxigeno\ExtranetBundle\Entity\FichaMedica $ficha_medica
     * @return \Oxigeno\ExtranetBundle\Entity\Paciente
     */
    public function setFichaMedica(FichaMedica $ficha_medica) {
        $this->ficha_medica = $ficha_medica;
        return $this;
    }
    
    
}
