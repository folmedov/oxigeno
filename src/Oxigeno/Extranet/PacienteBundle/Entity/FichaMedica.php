<?php

namespace Oxigeno\Extranet\PacienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Oxigeno\Extranet\PacienteBundle\Entity\Paciente;

/**
 * FichaMedica
 *
 * @ORM\Table(name="ficha_medica")
 * @ORM\Entity
 */
class FichaMedica {

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
     * @ORM\Column(name="diagnostico", type="text")
     */
    private $diagnostico;
    
    /**
     * @var Oxigeno\Extranet\PacienteBundle\Entity\Paciente
     * 
     */
    private $paciente;
    
    /**
     * @var Doctrine\Common\Collections\ArrayCollection;
     * 
     */
    private $terapias;
    
    
    public function __construct() {
        $this->terapias = new ArrayCollection();
    }

    public function __toString() {
        return $this->getDiagnostico();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set diagnostico
     *
     * @param string $diagnostico
     * @return FichaMedica
     */
    public function setDiagnostico($diagnostico) {
        $this->diagnostico = $diagnostico;

        return $this;
    }

    /**
     * Get diagnostico
     *
     * @return string 
     */
    public function getDiagnostico() {
        return $this->diagnostico;
    }
    
    /**
     * Get paciente
     * 
     * @return Oxigeno\Extranet\PacienteBundle\Entity\Paciente
     */
    public function getPaciente() {
        return $this->paciente;
    }
    
    /**
     * Set paciente
     * 
     * @param Oxigeno\Extranet\PacienteBundle\Entity\Paciente $paciente
     * @return \Oxigeno\Extranet\PacienteBundle\Entity\FichaMedica
     */
    public function setPaciente(Paciente $paciente) {
        $this->paciente = $paciente;
        return $this;
    }
    
    /**
     * Get Teraias
     * 
     * @return Doctrine\Common\Collections\ArrayCollection;
     */
    public function getTerapias() {
        return $this->terapias;
    }
    
    /**
     * Set Terapias
     * 
     * @param Doctrine\Common\Collections\ArrayCollection; $terapia
     * @return \Oxigeno\Extranet\PacienteBundle\Entity\FichaMedica
     */
    public function setTerapias(ArrayCollection $terapias) {
        $this->terapias = $terapias;
        return $this;
    }


}
