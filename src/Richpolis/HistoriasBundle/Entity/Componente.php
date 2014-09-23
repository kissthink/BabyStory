<?php

namespace Richpolis\HistoriasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Richpolis\FrontendBundle\Utils\Richsys as RpsStms;
/**
 * Componente
 *
 * @ORM\Table(name="componentes")
 * @ORM\Entity(repositoryClass="Richpolis\HistoriasBundle\Entity\ComponenteRepository")
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\Column(name="componente", type="text", nullable=true)
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

	
    const TIPO_IMAGEN=1;
    const TIPO_VIDEO=2;
    const TIPO_LINK=3;
    const TIPO_MUSICA=4;
    const TIPO_FLASH=5;
    const TIPO_DIALOGO=6;
    
    const TIPO_USUARIO_PAPA=1;
    const TIPO_USUARIO_HIJO=2;
        
    static public $sTipo=array(
        self::TIPO_IMAGEN=>'Imagen',
        self::TIPO_VIDEO=>'Video',
        self::TIPO_LINK=>'Link',
        self::TIPO_MUSICA=>'Musica',
        self::TIPO_FLASH=>'Flash',
        self::TIPO_DIALOGO=>'Dialogo',
    );
    
	public function getStringTipoCategoria(){
        return self::$sTipoCategoria[$this->getTipoCategoria()];
    }

    static function getArrayTipo(){
        return self::$sTipo;
    }

    static function getPreferedTipo(){
        return array(self::TIPO_DIALOGO);
    }
	
    public function __construct(){
	$this->tipo = self::TIPO_DIALOGO;
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
    
    /*** uploads ***/
    
    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->componente)) {
            // store the old name to delete after the update
            $this->temp = $this->componente;
            $this->componente = null;
        } else {
            $this->componente = 'initial';
        }
        $directorio=$this->getUploadRootDir();
        if(!file_exists($directorio)){
          mkdir($directorio, 0777);  
        }
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
    
    /**
    * @ORM\PrePersist
    * @ORM\PreUpdate
    */
    public function preUpload()
    {
      if (null !== $this->getFile()) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->componente = $filename.'.'.$this->getFile()->guessExtension();
        }
    }

    /**
    * @ORM\PostPersist
    * @ORM\PostUpdate
    */
    public function upload()
    {
      if (null === $this->getFile()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move($this->getUploadRootDir(), $this->componente);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir().'/'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->file = null;
    }

    /**
    * @ORM\PostRemove
    */
    public function removeUpload()
    {
      if ($file = $this->getAbsolutePath()) {
        if(file_exists($file)){
            unlink($file);
        }
      }
    }
    
    protected function getUploadDir()
    {
        return '/uploads/historias';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web'.$this->getUploadDir();
    }
    
    
    /**
     * Rutas de archivos 
     */
    public function getWebPath()
    {
        if($this->getTipo()==self::TIPO_LINK){
            return RpsStms::getVideoIdYoutube($this->componente);
        }else{
            return null === $this->componente ? null : $this->getUploadDir().'/'.$this->componente;
        }
    }
    
    public function getAbsolutePath()
    {
        return null === $this->componente ? null : $this->getUploadRootDir().'/'.$this->componente;
    }
    
    public function getTemplate(){
        switch($this->getTipo()){
            case self::TIPO_DIALOGO:
                if($this->getTipoUsuario() == self::TIPO_USUARIO_PAPA){
                    return 'FrontendBundle:Default:dialogoPapa.html.twig';
                }else{
                    return 'FrontendBundle:Default:dialogoNino.html.twig';
                }
            case self::TIPO_IMAGEN:
                return 'FrontendBundle:Default:imagenNino.html.twig';
            case self::TIPO_LINK:
                return 'FrontendBundle:Default:videoNino.html.twig';
            case self::TIPO_MUSICA:
                return 'FrontendBundle:Default:sonidoNino.html.twig';
            default:
                return 'FrontendBundle:Default:dialogoPapa.html.twig';
        } 
    }
}
