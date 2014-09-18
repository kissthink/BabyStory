<?php

namespace Richpolis\UsuariosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Roles
 *
 * @ORM\Table(name="roles")
 * @ORM\Entity
 */
class Roles implements RoleInterface
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="smallint")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="nombre", type="string", length=255, nullable=false)
	 */
	private $nombre;

	/**
	 * @var \Doctrine\Common\Collections\Collection
	 *
	 * @ORM\ManyToMany(targetEntity="Richpolis\UsuariosBundle\Entity\Usuario", mappedBy="rol")
	 */
	private $usuario;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->usuario = new \Doctrine\Common\Collections\ArrayCollection();
	}
        
    public function __toString(){
       return substr($this->getNombre(),5,strlen($this->getNombre()));
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
     * @return Roles
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
     * Add usuario
     *
     * @param \Richpolis\UsuariosBundle\Entity\Usuario $usuario
     * @return Roles
     */
    public function addUsuario(\Richpolis\UsuariosBundle\Entity\Usuario $usuario)
    {
        $this->usuario[] = $usuario;

        return $this;
    }

    /**
     * Remove usuario
     *
     * @param \Richpolis\UsuariosBundle\Entity\Usuario $usuario
     */
    public function removeUsuario(\Richpolis\UsuariosBundle\Entity\Usuario $usuario)
    {
        $this->usuario->removeElement($usuario);
    }

    /**
     * Get usuario
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
	
	public function getRole() 
	{
		return $this->nombre;
	}
}
