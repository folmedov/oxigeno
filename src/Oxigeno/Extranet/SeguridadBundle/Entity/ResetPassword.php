<?php

namespace Oxigeno\Extranet\SeguridadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ResetPassword
 *
 * @ORM\Table(name="reset_password")
 * @ORM\Entity
 */
class ResetPassword
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
     * @var Oxigeno\Extranet\SeguridadBundle\Entity\Usuario
     * 
     * @ORM\OneToOne(targetEntity="Oxigeno\Extranet\SeguridadBundle\Entity\Usuario", cascade={"persist"})
     */
    private $usuario;
    
    /**
     * @var \Oxigeno\Extranet\SeguridadBundle\Entity\Token
     * 
     * @ORM\ManyToOne(targetEntity="Oxigeno\Extranet\SeguridadBundle\Entity\Token", cascade={"persist"})
     */
    private $token;

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
     * Get usuario
     * 
     * @return \Oxigeno\Extranet\SeguridadBundle\Entity\Usuario
     */
    public function getUsuario() {
        return $this->usuario;
    }
    
    /**
     * Get token
     * 
     * @return \Oxigeno\Extranet\SeguridadBundle\Entity\Token
     */
    public function getToken() {
        return $this->token;
    }
    
    /**
     * Get usuario 
     * 
     * @param \Oxigeno\Extranet\SeguridadBundle\Entity\Usuario $usuario
     * @return \Oxigeno\Extranet\SeguridadBundle\Entity\ResetPassword
     */
    public function setUsuario($usuario) {
        $this->usuario = $usuario;
        return $this;
    }
    
    /**
     * Get Token
     * 
     * @param \Oxigeno\Extranet\SeguridadBundle\Entity\Token $token
     * @return \Oxigeno\Extranet\SeguridadBundle\Entity\ResetPassword
     */
    public function setToken($token) {
        $this->token = $token;
        return $this;
    }


}
