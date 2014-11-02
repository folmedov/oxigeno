<?php

namespace Oxigeno\ExtranetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Terapia
 *
 * @ORM\Table(name="terapia")
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"terapia" = "Terapia", 
 *                        "terapia_hiperbarica" = "TerapiaHiperbarica", 
 *                        "terapia_kinesiologica" = "TerapiaKinesiologica"})
 */
class Terapia
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
     * @ORM\Column(name="fecha_inicio", type="datetime")
     */
    private $fecha_inicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_termino", type="datetime")
     */
    private $fecha_termino;
    
    /**
     * @var Oxigeno\ExtranetBundle\Entity\FichaMedica
     * 
     * @ORM\ManyToOne(targetEntity="Oxigeno\ExtranetBundle\Entity\FichaMedica", cascade={"persist"})
     */
    private $ficha_medica;

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
     * Set fecha_inicio
     *
     * @param \DateTime $fechaInicio
     * @return Terapia
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fecha_inicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fecha_inicio
     *
     * @return \DateTime 
     */
    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }

    /**
     * Set fecha_termino
     *
     * @param \DateTime $fechaTermino
     * @return Terapia
     */
    public function setFechaTermino($fechaTermino)
    {
        $this->fecha_termino = $fechaTermino;

        return $this;
    }

    /**
     * Get fecha_termino
     *
     * @return \DateTime 
     */
    public function getFechaTermino()
    {
        return $this->fecha_termino;
    }
    
    public function getFichaMedica() {
        return $this->ficha_medica;
    }

    public function setFichaMedica($ficha_medica) {
        $this->ficha_medica = $ficha_medica;
        return $this;
    }


}
