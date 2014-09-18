<?php

namespace Richpolis\HistoriasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Historia
 *
 * @ORM\Table(name="historias")
 * @ORM\Entity(repositoryClass="Richpolis\HistoriasBundle\Entity\HistoriaRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Historia
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
     * @ORM\Column(name="historia", type="text")
     */
    private $historia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;
    
    
    /**
     * @var \Richpolis\UsuariosBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="Richpolis\UsuariosBundle\Entity\Usuario", inversedBy="historias")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * })
     */
    private $usuario;

    /**
     * Componentes de la historia
     *
     * @ORM\OneToMany(targetEntity="Richpolis\HistoriasBundle\Entity\Componente", mappedBy="historia")
     */
    private $componentes;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;
    
    
    public function __toString() {
        return "Historia " . $this->id;
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
     * Set historia
     *
     * @param string $historia
     * @return Historia
     */
    public function setHistoria($historia)
    {
        $this->historia = $historia;

        return $this;
    }

    /**
     * Get historia
     *
     * @return string 
     */
    public function getHistoria()
    {
        return $this->historia;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Historia
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->componentes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add componentes
     *
     * @param \Richpolis\HistoriasBundle\Entity\Historia $componentes
     * @return Historia
     */
    public function addComponente(\Richpolis\HistoriasBundle\Entity\Componente $componentes)
    {
        $this->componentes[] = $componentes;

        return $this;
    }

    /**
     * Remove componentes
     *
     * @param \Richpolis\HistoriasBundle\Entity\Historia $componentes
     */
    public function removeComponente(\Richpolis\HistoriasBundle\Entity\Componente $componentes)
    {
        $this->componentes->removeElement($componentes);
    }

    /**
     * Get componentes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComponentes()
    {
        return $this->componentes;
    }
    
    /*
     * Timestable
     */
    
    /**
     ** @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        if(!$this->getCreatedAt())
        {
          $this->createdAt = new \DateTime();
        }
        if(!$this->getUpdatedAt())
        {
          $this->updatedAt = new \DateTime();
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Historia
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Historia
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set usuario
     *
     * @param \Richpolis\UsuariosBundle\Entity\Usuario $usuario
     * @return Historia
     */
    public function setUsuario(\Richpolis\UsuariosBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Richpolis\UsuariosBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
