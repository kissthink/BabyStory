<?php

namespace Richpolis\HistoriasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comentario
 *
 * @ORM\Table(name="comentarios")
 * @ORM\Entity(repositoryClass="Richpolis\HistoriasBundle\Entity\ComentarioRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Comentario
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
     * @ORM\Column(name="comentario", type="text")
     */
    private $comentario;

    /**
     * @var \Richpolis\UsuariosBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="Richpolis\UsuariosBundle\Entity\Usuario", inversedBy="comentarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * })
     */
    private $usuario;

    /**
     * @var integer
     *
     * @ORM\Column(name="calificacion", type="integer")
     */
    private $calificacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;

    /**
     * @var \Richpolis\HistoriasBundle\Entity\Historia
     *
     * @ORM\ManyToOne(targetEntity="Richpolis\HistoriasBundle\Entity\Historia",inversedBy="comentarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="historia_id", referencedColumnName="id")
     * })
     */
    private $historia;


    

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
     * Set comentario
     *
     * @param string $comentario
     * @return Comentario
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * Get comentario
     *
     * @return string 
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * Set calificacion
     *
     * @param integer $calificacion
     * @return Comentario
     */
    public function setCalificacion($calificacion)
    {
        $this->calificacion = $calificacion;

        return $this;
    }

    /**
     * Get calificacion
     *
     * @return integer 
     */
    public function getCalificacion()
    {
        return $this->calificacion;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Comentario
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
     * @return Comentario
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
     * @return Comentario
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

    /**
     * Set historia
     *
     * @param \Richpolis\HistoriasBundle\Entity\Historia $historia
     * @return Comentario
     */
    public function setHistoria(\Richpolis\HistoriasBundle\Entity\Historia $historia = null)
    {
        $this->historia = $historia;

        return $this;
    }

    /**
     * Get historia
     *
     * @return \Richpolis\HistoriasBundle\Entity\Historia 
     */
    public function getHistoria()
    {
        return $this->historia;
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
}
