<?php

namespace Oxigeno\Extranet\SeguridadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Oxigeno\Extranet\PacienteBundle\Entity\Util;

/**
 * Token
 *
 * @ORM\Table(name="token")
 * @ORM\Entity(repositoryClass="Oxigeno\Extranet\SeguridadBundle\Entity\Repository\TokenRepository")
 */
class Token
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
     * @ORM\Column(name="token", type="string", length=255)
     */
    private $token;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_creacion", type="datetime")
     */
    private $fecha_creacion;
    
    /**
     * @var \Datetime
     * 
     * @ORM\Column(name="fecha_validez", type="datetime")
     */
    private $fecha_vencimiento;
    
    private $tiempo_validez = '1';
    
    public function __construct() {
        $this->token = Util::generarContrasena(32);
        $this->fecha_creacion = new \DateTime('now');
        $this->fecha_vencimiento = new \DateTime('now + '.$this->tiempo_validez.' hour');
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
     * Set key
     *
     * @param string $token
     * @return Token
     */
    public function setKey($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get key
     *
     * @return string 
     */
    public function getKey()
    {
        return $this->token;
    }

    /**
     * Set fecha_creacion
     *
     * @param \DateTime $fechaCreacion
     * @return Token
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fecha_creacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fecha_creacion
     *
     * @return \DateTime 
     */
    public function getFechaCreacion()
    {
        return $this->fecha_creacion;
    }
    
    /**
     * Get fecha_validez
     * 
     * @return \Datetime
     */
    public function getFechaValidez() {
        return $this->fecha_vencimiento;
    }
    
    /**
     * Set fecha_validez
     * 
     * @param \Datetime $fecha_validez
     * @return \Oxigeno\Extranet\SeguridadBundle\Entity\Token
     */
    public function setFechaValidez(\Datetime $fecha_validez) {
        $this->fecha_vencimiento = $fecha_validez;
        return $this;
    }
    
    public function isValid() {
        if ($this->getFechaValidez() > new \DateTime('now')) {
            return true;
        } else {
            return false;
        }
    }
    
}
