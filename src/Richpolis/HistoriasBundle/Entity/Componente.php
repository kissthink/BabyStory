<?php

namespace Richpolis\HistoriasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Componente
 *
 * @ORM\Table(name="componentes")
 * @ORM\Entity(repositoryClass="Richpolis\HistoriasBundle\Entity\ComponenteRepository")
 */
class Componente
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
     * @var integer
     *
     * @ORM\Column(name="tipo", type="integer")
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="componente", type="text")
     */
    private $componente;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipoUsuario", type="integer")
     */
    private $tipoUsuario;

    /**
     * @var \Richpolis\UsuariosBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="Richpolis\UsuariosBundle\Entity\Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="papa_id", referencedColumnName="id")
     * })
     */
    private $papa;

    /**
     * @var \Richpolis\UsuariosBundle\Entity\Hijo
     *
     * @ORM\ManyToOne(targetEntity="Richpolis\UsuariosBundle\Entity\Hijo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="hijo_id", referencedColumnName="id")
     * })
     */
    private $hijo;

    /**
     * @var \Richpolis\HistoriasBundle\Entity\Historia
     *
     * @ORM\ManyToOne(targetEntity="Richpolis\HistoriasBundle\Entity\Historia",inversedBy="componentes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="historia_id", referencedColumnName="id")
     * })
     */
    private $historia;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

	
	
    

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
     * Set tipo
     *
     * @param integer $tipo
     * @return Componente
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return integer 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set componente
     *
     * @param string $componente
     * @return Componente
     */
    public function setComponente($componente)
    {
        $this->componente = $componente;

        return $this;
    }

    /**
     * Get componente
     *
     * @return string 
     */
    public function getComponente()
    {
        return $this->componente;
    }

    /**
     * Set tipoUsuario
     *
     * @param integer $tipoUsuario
     * @return Componente
     */
    public function setTipoUsuario($tipoUsuario)
    {
        $this->tipoUsuario = $tipoUsuario;

        return $this;
    }

    /**
     * Get tipoUsuario
     *
     * @return integer 
     */
    public function getTipoUsuario()
    {
        return $this->tipoUsuario;
    }

    /**
     * Set papa
     *
     * @param integer $papa
     * @return Componente
     */
    public function setPapa($papa)
    {
        $this->papa = $papa;

        return $this;
    }

    /**
     * Get papa
     *
     * @return integer 
     */
    public function getPapa()
    {
        return $this->papa;
    }

    /**
     * Set hijo
     *
     * @param integer $hijo
     * @return Componente
     */
    public function setHijo($hijo)
    {
        $this->hijo = $hijo;

        return $this;
    }

    /**
     * Get hijo
     *
     * @return integer 
     */
    public function getHijo()
    {
        return $this->hijo;
    }

    /**
     * Set historia
     *
     * @param integer $historia
     * @return Componente
     */
    public function setHistoria($historia)
    {
        $this->historia = $historia;

        return $this;
    }

    /**
     * Get historia
     *
     * @return integer 
     */
    public function getHistoria()
    {
        return $this->historia;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Componente
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }
}
