<?php

namespace Oxigeno\ExtranetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Archivo
 *
 * @ORM\Table(name="archivo")
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"archivo" = "Archivo", "fotografia" = "Fotografia"})
 */
class Archivo {

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
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @var string 
     * 
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="myme", type="string", length=50, nullable=true)
     */
    private $myme;

    /**
     * @var UploadedFile 
     * 
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Archivo
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Set myme
     *
     * @param string $myme
     * @return Archivo
     */
    public function setMyme($myme) {
        $this->myme = $myme;

        return $this;
    }

    /**
     * Get myme
     *
     * @return string 
     */
    public function getMyme() {
        return $this->myme;
    }

    /**
     * Get Path
     * 
     * @return string
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * Set Path
     * 
     * @param string $path
     * @return \Oxigeno\ExtranetBundle\Entity\Archivo
     */
    public function setPath($path) {
        $this->path = $path;
        return $this;
    }

    /**
     * Get File
     * 
     * @return UploadedFile
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * Set UploadedFile
     * 
     * @param UploadedFile $file
     * @return \Oxigeno\ExtranetBundle\Entity\Archivo
     */
    public function setFile(UploadedFile $file) {
        $this->file = $file;
        return $this;
    }

    public function getAbsolutePath() {
        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->path;
    }

    public function getWebPath() {
        return null === $this->path ? null : $this->getUploadDir() . '/' . $this->path;
    }

    protected function getUploadRootDir() {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir() {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/documents';
    }

    public function upload() {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues
        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
                $this->getUploadRootDir(), $this->getFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->path = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }

}
