<?php

namespace Oxigeno\Extranet\PacienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fotografia
 *
 * @ORM\Table(name="fotografia")
 * @ORM\Entity
 */
class Fotografia extends Archivo {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    public function __construct() {
        $this->setPath('avatar-el.png');
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    protected function getUploadDir() {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/images/perfil';
    }

}
