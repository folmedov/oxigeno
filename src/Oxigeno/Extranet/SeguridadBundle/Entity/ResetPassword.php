<?php

namespace Oxigeno\Extranet\SeguridadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Oxigeno\Extranet\SeguridadBundle\Entity\Token;

/**
 * ResetPassword
 *
 * @ORM\Table(name="reset_password")
 * @ORM\Entity(repositoryClass="Oxigeno\Extranet\SeguridadBundle\Entity\Repository\ResetPasswordRepository")
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
     * @ORM\ManyToOne(targetEntity="Oxigeno\Extranet\SeguridadBundle\Entity\Usuario", 
     *                inversedBy="solicitudes_reset_password", 
     *                cascade={"persist"})
     */
    private $usuario;
    
    /**
     * @var Oxigeno\Extranet\SeguridadBundle\Entity\Token
     * 
     * @ORM\ManyToOne(targetEntity="Oxigeno\Extranet\SeguridadBundle\Entity\Token", cascade={"persist"})
     */
    private $token;
    
    public function __construct() {
        $this->token = new Token();
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
     * Get usuario
     * 
     * @return \Oxigeno\Extranet\SeguridadBundle\Entity\Usuario
     */
    public function getUsuario() {
        return $this->usuario;
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
     * Get token
     * 
     * @return Oxigeno\Extranet\SeguridadBundle\Entity\Token
     */
    public function getToken() {
        return $this->token;
    }
    
    /**
     * Get Token
     * 
     * @param Oxigeno\Extranet\SeguridadBundle\Entity\Token $tokens
     * @return \Oxigeno\Extranet\SeguridadBundle\Entity\ResetPassword
     */
    public function setToken(Token $token) {
        $this->token = $tokens;
        return $this;
    }
    
    /**
     * Determina si la lista de tokens es valida
     * 
     * @return boolean
     */
    public function esTokenValido() {
        if (!$this->token->isValid()) {
            return false;
        }
        return true;
    }

}
