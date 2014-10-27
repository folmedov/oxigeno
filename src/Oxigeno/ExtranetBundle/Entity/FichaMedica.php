<?php

namespace Oxigeno\ExtranetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Oxigeno\ExtranetBundle\Entity\Paciente;

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
     * @var Oxigeno\ExtranetBundle\Entity\Paciente
     * 
     * @ORM\OneToOne(targetEntity="Oxigeno\ExtranetBundle\Entity\Paciente", inversedBy="ficha_medica")
     */
    private $paciente;

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
     * @return Oxigeno\ExtranetBundle\Entity\Paciente
     */
    public function getPaciente() {
        return $this->paciente;
    }
    
    /**
     * Set paciente
     * 
     * @param Oxigeno\ExtranetBundle\Entity\Paciente $paciente
     * @return \Oxigeno\ExtranetBundle\Entity\FichaMedica
     */
    public function setPaciente($paciente) {
        $this->paciente = $paciente;
        return $this;
    }



}
