<?php

namespace Oxigeno\Extranet\SeguridadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;

use Oxigeno\Extranet\PacienteBundle\Entity\Persona;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario")
 * @ORM\Entity(repositoryClass="Oxigeno\Extranet\SeguridadBundle\Entity\Repository\UsuarioRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"usuario" = "Usuario", "administrador" = "Administrador"})
 */
class Usuario implements UserInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=100)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;
    
    /**
     * @var Oxigeno\Extranet\PacienteBundle\Entity\Persona
     * 
     * @ORM\ManyToOne(targetEntity="Oxigeno\Extranet\PacienteBundle\Entity\Persona", cascade={"persist"})
     */
    private $persona;
    
    /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="Oxigeno\Extranet\SeguridadBundle\Entity\ResetPassword", 
     *                mappedBy="usuario")
     */
    private $solicitudes_reset_password;
    
    public function __construct() {
        $this->solicitudes_reset_password = new ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     * @return Usuario
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Usuario
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Usuario
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    
        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Usuario
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Get persona
     * 
     * @return Oxigeno\Extranet\PacienteBundle\Entity\Persona
     */
    function getPersona() {
        return $this->persona;
    }

    /**
     * Set persona
     * 
     * @param \Oxigeno\Extranet\PacienteBundle\Entity\Persona $persona
     * @return \Oxigeno\Extranet\SeguridadBundle\Entity\Usuario
     */
    function setPersona(Persona $persona) {
        $this->persona = $persona;
        return $this;
    }
    
    /**
     * Get Solicitudes Reset Password
     * 
     * @return ArrayCollection
     */
    public function getSolicitudesResetPassword() {
        return $this->solicitudes_reset_password;
    }
    
    /**
     * Set Solicitudes Reset Password
     * 
     * @param ArrayCollection $solicitudes_reset_password
     * @return \Oxigeno\Extranet\SeguridadBundle\Entity\Usuario
     */
    public function setSolicitudesResetPassword(ArrayCollection $solicitudes_reset_password) {
        $this->solicitudes_reset_password = $solicitudes_reset_password;
        return $this;
    }
    
    public function eraseCredentials() {
        
    }

    public function getRoles() {
        return array('ROLE_USUARIO');
    }

    public function getUsername() {
        return $this->getNombre();
    }
    
    public function esValidoSolicitarRestablecerPassword() {
        foreach ($this->solicitudes_reset_password as $solicitudRestablecerPassword) {
            // si el token es valido, es decir que ya se ha solicitado restablecer 
            // contraseña entonces no se debe poder enviar una nueva contraseña
            // para evitar spam
            if ($solicitudRestablecerPassword->esTokenValido()) {
                return false;
            }
        }
        return true;
    }

}
