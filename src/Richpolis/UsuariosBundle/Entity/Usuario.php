<?php

namespace Richpolis\UsuariosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * Usuario
 *
 * @ORM\Table(name="usuarios")
 * @ORM\Entity(repositoryClass="Richpolis\UsuariosBundle\Entity\UsuarioRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("email")
 */
class Usuario implements UserInterface, \Serializable 
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
     * @ORM\Column(name="username", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message = "Por favor ingresa tu usuario")
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     * @Assert\Length(min = 6)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=false)
     */
    private $salt;
    
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="ciudad", type="string", length=255,nullable=true)
     */
    private $ciudad;

    /**
     * @var string
     *
     * @ORM\Column(name="biografia", type="text",nullable=true)
     */
    private $biografia;

    /**
     * @var string
     *
     * @ORM\Column(name="serMadre", type="text",nullable=true)
     */
    private $serMadre;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="sexo", type="integer")
     */
    private $sexo;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen", type="string", length=255, nullable=true)
     */
    private $imagen;
    
    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Richpolis\UsuariosBundle\Entity\Roles", inversedBy="usuario")
     * @ORM\JoinTable(name="usuario_rol",
     *   joinColumns={
     *     @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="rol_id", referencedColumnName="id")
     *   }
     * )
     */
    private $rol;
	
    /**
     * Hijos del Usuario
     *
     * @ORM\OneToMany(targetEntity="Richpolis\UsuariosBundle\Entity\Hijo", mappedBy="papa")
     */
    private $hijos;

    /**
     * Historias del usuario
     *
     * @ORM\OneToMany(targetEntity="Richpolis\HistoriasBundle\Entity\Historia", mappedBy="usuario")
     */
    private $historias;
    
    
    /**
     * Comentarios del usuario
     *
     * @ORM\OneToMany(targetEntity="Richpolis\HistoriasBundle\Entity\Comentario", mappedBy="usuario")
     */
    private $comentarios;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;
    
    /** @ORM\Column(name="facebook_id", type="string", length=255, nullable=true) */
    protected $facebook_id;
 
    /** @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true) */
    protected $facebook_access_token;
 
    /** @ORM\Column(name="google_id", type="string", length=255, nullable=true) */
    protected $google_id;
 
    /** @ORM\Column(name="google_access_token", type="string", length=255, nullable=true) */
    protected $google_access_token;
    
    /** @ORM\Column(name="twitter_id", type="string", length=255, nullable=true) */
    protected $twitter_id;
 
    /** @ORM\Column(name="twitter_access_token", type="string", length=255, nullable=true) */
    protected $twitter_access_token;
    
    

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;
    
    public $ninos;
    
    public $ninas;
    
    const INDEFINIDO = 0;
    const PAPA = 1;
    const MAMA = 2;
    
    static public $sSexo=array(
        self::INDEFINIDO=>'Es papa o mama?',
        self::PAPA=>'Papa',
        self::MAMA=>'Mama',
    );
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rol = new \Doctrine\Common\Collections\ArrayCollection();
        // may not be needed, see section on salt below
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $this->ninos = 0;
        $this->ninas = 0;
        $this->isActive = true;
        $this->sexo= self::INDEFINIDO;
    }
    
    public function getStringSexo(){
        return self::$sSexo[$this->getSexo()];
    }

    static function getArraySexo(){
        return self::$sSexo;
    }

    static function getPreferedSexo(){
        return array(self::INDEFINIDO);
    }
    
    public function __toString() {
        return $this->username;
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
     * Set ciudad
     *
     * @param string $ciudad
     * @return Usuario
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return string 
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Set biografia
     *
     * @param string $biografia
     * @return Usuario
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
     * Set serMadre
     *
     * @param string $serMadre
     * @return Usuario
     */
    public function setSerMadre($serMadre)
    {
        $this->serMadre = $serMadre;

        return $this;
    }

    /**
     * Get serMadre
     *
     * @return string 
     */
    public function getSerMadre()
    {
        return $this->serMadre;
    }

    /**
     * Set imagen
     *
     * @param string $imagen
     * @return Usuario
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
     * Set username
     *
     * @param string $username
     * @return Usuario
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
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
     * @see UserInterface::getRoles
     */
    public function getRoles() {

        return $this->rol->toArray();
    }

    /**
     * @see UserInterface::eraseCredentials
     */
    public function eraseCredentials() {
        
    }

    /**
     * Serializes the content of the current User object
     * @return string
     */
    public function serialize() {
        return \json_encode(
                array($this->username, $this->password, $this->rol->toArray(), $this->salt, $this->id)
        );
    }

    /**
     * @param $serialized
     */
    public function unserialize($serialized) {
        list($this->username, $this->password, $this->rol, $this->salt, $this->id) = \json_decode($serialized);
    }
    

    /**
     * Add rol
     *
     * @param \Richpolis\UsuariosBundle\Entity\Roles $rol
     * @return Usuario
     */
    public function addRol(\Richpolis\UsuariosBundle\Entity\Roles $rol)
    {
        $this->rol[] = $rol;

        return $this;
    }

    /**
     * Remove rol
     *
     * @param \Richpolis\UsuariosBundle\Entity\Roles $rol
     */
    public function removeRol(\Richpolis\UsuariosBundle\Entity\Roles $rol)
    {
        $this->rol->removeElement($rol);
    }

    /**
     * Get rol
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Add hijos
     *
     * @param \Richpolis\UsuariosBundle\Entity\Hijo $hijos
     * @return Usuario
     */
    public function addHijo(\Richpolis\UsuariosBundle\Entity\Hijo $hijos)
    {
        $this->hijos[] = $hijos;

        return $this;
    }

    /**
     * Remove hijos
     *
     * @param \Richpolis\UsuariosBundle\Entity\Hijo $hijos
     */
    public function removeHijo(\Richpolis\UsuariosBundle\Entity\Hijo $hijos)
    {
        $this->hijos->removeElement($hijos);
    }

    /**
     * Get hijos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHijos()
    {
        return $this->hijos;
    }
    
    public function setNinos($ninos){
        $this->ninos=$ninos;
    }
    
    public function setNinas($ninas){
        $this->ninas = $ninas;
    }
    
    public function getNinos(){
        return $this->ninos;
    }
    
    public function getNinas(){
        return $this->ninas;
    }
    
    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Usuario
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
     * @return Usuario
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
     * Add historias
     *
     * @param \Richpolis\HistoriasBundle\Entity\Historia $historias
     * @return Usuario
     */
    public function addHistoria(\Richpolis\HistoriasBundle\Entity\Historia $historias)
    {
        $this->historias[] = $historias;

        return $this;
    }

    /**
     * Remove historias
     *
     * @param \Richpolis\HistoriasBundle\Entity\Historia $historias
     */
    public function removeHistoria(\Richpolis\HistoriasBundle\Entity\Historia $historias)
    {
        $this->historias->removeElement($historias);
    }

    /**
     * Get historias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHistorias()
    {
        return $this->historias;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Usuario
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }    
    
    /**
     * Add comentarios
     *
     * @param \Richpolis\HistoriasBundle\Entity\Comentario $comentarios
     * @return Usuario
     */
    public function addComentario(\Richpolis\HistoriasBundle\Entity\Comentario $comentarios)
    {
        $this->comentarios[] = $comentarios;

        return $this;
    }

    /**
     * Remove comentarios
     *
     * @param \Richpolis\HistoriasBundle\Entity\Comentario $comentarios
     */
    public function removeComentario(\Richpolis\HistoriasBundle\Entity\Comentario $comentarios)
    {
        $this->comentarios->removeElement($comentarios);
    }

    /**
     * Get comentarios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }

    /**
     * Set sexo
     *
     * @param integer $sexo
     * @return Usuario
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return integer 
     */
    public function getSexo()
    {
        return $this->sexo;
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
    
    /*** uploads ***/
    
    /**
     * @Assert\File(maxSize="2M",maxSizeMessage="El archivo es demasiado grande. El tamaño máximo permitido es {{ limit }}")
     */
    public $file;
    
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->imagen)) {
            // store the old name to delete after the update
            $this->temp = $this->imagen;
            $this->imagen = null;
        } else {
            $this->imagen = 'initial';
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
            $this->imagen = $filename.'.'.$this->getFile()->guessExtension();
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
        $this->getFile()->move($this->getUploadRootDir(), $this->imagen);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            if(file_exists($this->getUploadRootDir().'/'.$this->temp)){
                unlink($this->getUploadRootDir().'/'.$this->temp);
            }
            // clear the temp image path
            $this->temp = null;
        }
        
        $this->crearThumbnail();
        
        $this->file = null;
    }
    
    /*
     * Crea el thumbnail y lo guarda en un carpeta dentro del webPath thumbnails
     * 
     * @return void
     */
    public function crearThumbnail($width=100,$height=100,$path=""){
        $imagine    = new \Imagine\Gd\Imagine();
        $collage    = $imagine->create(new \Imagine\Image\Box(100, 100));
        $mode       = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
        $image      = $imagine->open($this->getAbsolutePath());
        $sizeImage  = $image->getSize();
        if(strlen($path)==0){
            $path = $this->getAbosluteThumbnailPath();
        }
        if($height == null){
            $height = $sizeImage->getHeight();
            if($height>100){
                $height = 100;
            }
        }
        if($width == null){
            $width = $sizeImage->getWidth();
            if($width>100){
                $width = 100;
            }
        }
        $size   =new \Imagine\Image\Box($width,$height);
        $image->thumbnail($size,$mode)->save($path);
        $image  = $imagine->open($path);
        $size = $image->getSize();
        if((100 - $size->getWidth())>1){
            $width = ceil((100 - $size->getWidth())/2);
        }else{
            $width = 0;
        }
        if((100 - $size->getHeight())>1){
            $height = ceil((100 - $size->getHeight())/2);
        }else{
            $height =0;
        }    
        $centrado = new \Imagine\Image\Point($width, $height);
        $collage->paste($image,$centrado);
        $collage->save($path);        
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
      if($thumbnail=$this->getAbosluteThumbnailPath()){
         if(file_exists($thumbnail)){
            unlink($thumbnail);
        }
      }
    }
    
    protected function getUploadDir()
    {
        return '/uploads/usuarios';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web'.$this->getUploadDir();
    }
    
    public function getWebPath()
    {
        return null === $this->imagen ? null : $this->getUploadDir().'/'.$this->imagen;
    }
    
    public function getThumbnailWebPath()
    {
        if(!file_exists($this->getAbosluteThumbnailPath())){
            if(file_exists($this->getAbsolutePath())){
                $this->crearThumbnail();
            }
        }
        return null === $this->imagen ? null : $this->getUploadDir().'/thumbnails/'.$this->imagen;
        
    }
    
    public function getAbsolutePath()
    {
        return null === $this->imagen ? null : $this->getUploadRootDir().'/'.$this->imagen;
    }
    
    public function getAbosluteThumbnailPath(){
        return null === $this->imagen ? null : $this->getUploadRootDir().'/thumbnails/'.$this->imagen;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return Usuario
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set facebook_id
     *
     * @param string $facebookId
     * @return Usuario
     */
    public function setFacebookId($facebookId)
    {
        $this->facebook_id = $facebookId;

        return $this;
    }

    /**
     * Get facebook_id
     *
     * @return string 
     */
    public function getFacebookId()
    {
        return $this->facebook_id;
    }

    /**
     * Set facebook_access_token
     *
     * @param string $facebookAccessToken
     * @return Usuario
     */
    public function setFacebookAccessToken($facebookAccessToken)
    {
        $this->facebook_access_token = $facebookAccessToken;

        return $this;
    }

    /**
     * Get facebook_access_token
     *
     * @return string 
     */
    public function getFacebookAccessToken()
    {
        return $this->facebook_access_token;
    }

    /**
     * Set google_id
     *
     * @param string $googleId
     * @return Usuario
     */
    public function setGoogleId($googleId)
    {
        $this->google_id = $googleId;

        return $this;
    }

    /**
     * Get google_id
     *
     * @return string 
     */
    public function getGoogleId()
    {
        return $this->google_id;
    }

    /**
     * Set google_access_token
     *
     * @param string $googleAccessToken
     * @return Usuario
     */
    public function setGoogleAccessToken($googleAccessToken)
    {
        $this->google_access_token = $googleAccessToken;

        return $this;
    }

    /**
     * Get google_access_token
     *
     * @return string 
     */
    public function getGoogleAccessToken()
    {
        return $this->google_access_token;
    }

    /**
     * Set twitter_id
     *
     * @param string $twitterId
     * @return Usuario
     */
    public function setTwitterId($twitterId)
    {
        $this->twitter_id = $twitterId;

        return $this;
    }

    /**
     * Get twitter_id
     *
     * @return string 
     */
    public function getTwitterId()
    {
        return $this->twitter_id;
    }

    /**
     * Set twitter_access_token
     *
     * @param string $twitterAccessToken
     * @return Usuario
     */
    public function setTwitterAccessToken($twitterAccessToken)
    {
        $this->twitter_access_token = $twitterAccessToken;

        return $this;
    }

    /**
     * Get twitter_access_token
     *
     * @return string 
     */
    public function getTwitterAccessToken()
    {
        return $this->twitter_access_token;
    }
}
