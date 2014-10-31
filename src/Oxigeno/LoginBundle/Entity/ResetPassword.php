<?php

namespace Oxigeno\LoginBundle\Entity;

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
     * @var Oxigeno\LoginBundle\Entity\Usuario
     * 
     * @ORM\OneToOne(targetEntity="Oxigeno\LoginBundle\Entity\Usuario", cascade={"persist"})
     */
    private $usuario;
    
    /**
     * @var \Oxigeno\LoginBundle\Entity\Token
     * 
     * @ORM\ManyToOne(targetEntity="Oxigeno\LoginBundle\Entity\Token", cascade={"persist"})
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
     * @return \Oxigeno\LoginBundle\Entity\Usuario
     */
    public function getUsuario() {
        return $this->usuario;
    }
    
    /**
     * Get token
     * 
     * @return \Oxigeno\LoginBundle\Entity\Token
     */
    public function getToken() {
        return $this->token;
    }
    
    /**
     * Get usuario 
     * 
     * @param \Oxigeno\LoginBundle\Entity\Usuario $usuario
     * @return \Oxigeno\LoginBundle\Entity\ResetPassword
     */
    public function setUsuario($usuario) {
        $this->usuario = $usuario;
        return $this;
    }
    
    /**
     * Get Token
     * 
     * @param \Oxigeno\LoginBundle\Entity\Token $token
     * @return \Oxigeno\LoginBundle\Entity\ResetPassword
     */
    public function setToken($token) {
        $this->token = $token;
        return $this;
    }


}
