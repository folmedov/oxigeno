<?php

namespace Oxigeno\ExtranetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\ExecutionContext;
use Oxigeno\ExtranetBundle\Entity\Direccion;
use Oxigeno\ExtranetBundle\Entity\Telefono;

/**
 * Persona
 *
 * @ORM\Table(name="persona")
 * @ORM\Entity
 * @UniqueEntity("rut")
 * @Assert\Callback(methods={"esRutValido"})
 */
class Persona
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
     * @Assert\Length(min=8, max=9)
     * @ORM\Column(name="rut", type="string", length=9, unique=true)
     */
    private $rut;

    /**
     * @var string
     *
     * @Assert\Length(max=100)
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var string
     *
     * @Assert\Length(max=100)
     * @ORM\Column(name="apellido", type="string", length=100)
     */
    private $apellido;

    /**
     * @var \DateTime
     *
     * @Assert\Date()
     * @ORM\Column(name="fecha_nacimiento", type="datetime")
     */
    private $fecha_nacimiento;

    /**
     * @var string
     *
     * @Assert\Email()
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;
    
    /**
     * @var Oxigeno\ExtranetBundle\Entity\Direccion
     * 
     * @ORM\OneToOne(targetEntity="Oxigeno\ExtranetBundle\Entity\Direccion", mappedBy="persona", cascade={"persist"})
     */
    private $direccion;
    
    /**
     * @var Telefono
     * 
     * @ORM\OneToMany(targetEntity="Oxigeno\ExtranetBundle\Entity\Telefono", mappedBy="persona", cascade={"persist"})
     */
    private $telefonos;
    
    public function __construct() {
        $this->direccion = new Direccion();
        $this->telefonos = new ArrayCollection(array(new Telefono(), new Telefono()));
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
     * Set rut
     *
     * @param string $rut
     * @return Persona
     */
    public function setRut($rut)
    {
        $this->rut = $rut;

        return $this;
    }

    /**
     * Get rut
     *
     * @return string 
     */
    public function getRut()
    {
        return $this->rut;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Persona
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
     * Set apellido
     *
     * @param string $apellido
     * @return Persona
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set fecha_nacimiento
     *
     * @param \DateTime $fechaNacimiento
     * @return Persona
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fecha_nacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fecha_nacimiento
     *
     * @return \DateTime 
     */
    public function getFechaNacimiento()
    {
        return $this->fecha_nacimiento;
    }

    /**
     * Set email
     *
     * @param string $correo
     * @return Persona
     */
    public function setEmail($correo)
    {
        $this->email = $correo;

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
     * Get direccion
     * 
     * @return Oxigeno\ExtranetBundle\Entity\Direccion
     */
    public function getDireccion() {
        return $this->direccion;
    }
    
    /**
     * Set direccion
     * 
     * @param Oxigeno\ExtranetBundle\Entity\Direccion $direccion
     * @return \Oxigeno\ExtranetBundle\Entity\Persona
     */
    public function setDireccion(Direccion $direccion) {
        $this->direccion = $direccion;
        return $this;
    }
    
    /**
     * Get telefono
     * 
     * @return Telefono
     */
    public function getTelefonos() {
        return $this->telefonos;
    }
    
    /**
     * Set telefono
     * 
     * @param Telefono $telefono
     * @return \Oxigeno\ExtranetBundle\Entity\Persona
     */
    public function setTelefonos(Telefono $telefono) {
        $this->telefonos = $telefono;
        return $this;
    }
    
    public function __toString() {
        return $this->getNombre().' '.$this->getApellido();
    }
    
    public function esRutValido(ExecutionContext $context) {
        $rut = $this->getRut();
        $r = strtoupper(str_replace(array(".", "-"), "", $rut));
        $sub_rut = substr($r, 0, strlen($r) - 1);
        $sub_dv = substr($r, - 1);
        $x = 2;
        $s = 0;
        for ($i = strlen($sub_rut) - 1; $i >= 0; $i--) {
            if ($x > 7) {
                $x = 2;
            }
            $s += $sub_rut[$i] * $x;
            $x++;
        }
        $dv = 11 - ($s % 11);
        if ($dv == 10) {
            $dv = 'K';
        }
        if ($dv == 11) {
            $dv = '0';
        }
        
        if ($dv != $sub_dv) {
            $context->addViolationAtSubPath($rut, 'El rut ingresado no es valido', array(), null);
            return;
        }
    }
    
}
