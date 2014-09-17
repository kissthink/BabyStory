<?php

namespace Richpolis\UsuariosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hijo
 *
 * @ORM\Table(name="hijos")
 * @ORM\Entity(repositoryClass="Richpolis\UsuariosBundle\Entity\HijoRepository")
 */
class Hijo
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apodo", type="string", length=255)
     */
    private $apodo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="usarApodo", type="boolean")
     */
    private $usarApodo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaNacimiento", type="date")
     */
    private $fechaNacimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="biografia", type="text")
     */
    private $biografia;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen", type="string", length=255)
     */
    private $imagen;

    /**
     * @var \Richpolis\UsuariosBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="Richpolis\UsuariosBundle\Entity\Usuario", inversedBy="hijos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="papa_id", referencedColumnName="id")
     * })
     */
    private $papa;


 

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
     * @return Hijo
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
     * Set apodo
     *
     * @param string $apodo
     * @return Hijo
     */
    public function setApodo($apodo)
    {
        $this->apodo = $apodo;

        return $this;
    }

    /**
     * Get apodo
     *
     * @return string 
     */
    public function getApodo()
    {
        return $this->apodo;
    }

    /**
     * Set usarApodo
     *
     * @param boolean $usarApodo
     * @return Hijo
     */
    public function setUsarApodo($usarApodo)
    {
        $this->usarApodo = $usarApodo;

        return $this;
    }

    /**
     * Get usarApodo
     *
     * @return boolean 
     */
    public function getUsarApodo()
    {
        return $this->usarApodo;
    }

    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     * @return Hijo
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime 
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * Set biografia
     *
     * @param string $biografia
     * @return Hijo
     */
    public function setBiografia($biografia)
    {
        $this->biografia = $biografia;

        return $this;
    }

    /**
     * Get biografia
     *
     * @return string 
     */
    public function getBiografia()
    {
        return $this->biografia;
    }

    /**
     * Set imagen
     *
     * @param string $imagen
     * @return Hijo
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get imagen
     *
     * @return string 
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set papa
     *
     * @param \Richpolis\UsuariosBundle\Entity\Usuario $papa
     * @return Hijo
     */
    public function setPapa(\Richpolis\UsuariosBundle\Entity\Usuario $papa = null)
    {
        $this->papa = $papa;

        return $this;
    }

    /**
     * Get papa
     *
     * @return \Richpolis\UsuariosBundle\Entity\Usuario 
     */
    public function getPapa()
    {
        return $this->papa;
    }
}
