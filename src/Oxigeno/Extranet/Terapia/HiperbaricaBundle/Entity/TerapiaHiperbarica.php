<?php

namespace Oxigeno\Extranet\Terapia\HiperbaricaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TerapiaHiperbarica
 *
 * @ORM\Table(name="terapia_hiperbarica")
 * @ORM\Entity
 */
class TerapiaHiperbarica extends Terapia
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
     * @var integer
     *
     * @ORM\Column(name="numero_estimado_sesiones", type="integer")
     */
    private $numero_estimado_sesiones;


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
     * Set numero_estimado_sesiones
     *
     * @param integer $numeroEstimadoSesiones
     * @return TerapiaHiperbarica
     */
    public function setNumeroEstimadoSesiones($numeroEstimadoSesiones)
    {
        $this->numero_estimado_sesiones = $numeroEstimadoSesiones;

        return $this;
    }

    /**
     * Get numero_estimado_sesiones
     *
     * @return integer 
     */
    public function getNumeroEstimadoSesiones()
    {
        return $this->numero_estimado_sesiones;
    }
}
