<?php

namespace Richpolis\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Richpolis\UsuariosBundle\Entity\Usuario;
use Richpolis\UsuariosBundle\Entity\Hijo;
use Richpolis\UsuariosBundle\Form\UsuarioFrontendType;
use Richpolis\UsuariosBundle\Form\HijoFrontendType;
use Richpolis\HistoriasBundle\Form\HistoriaFrontendType;
use Richpolis\HistoriasBundle\Entity\Historia;
use Richpolis\HistoriasBundle\Entity\Comentario;
use Symfony\Component\HttpFoundation\JsonResponse;
use Richpolis\HistoriasBundle\Entity\Componente;
use Richpolis\FrontendBundle\Utils\Richsys as RpsStms;


class DefaultController extends Controller
{
    /**
     * @Route("/",name="portada")
     * @Template()
     */
    public function portadaAction()
    {
        return array();
    }

    /**
     * @Route("/busqueda",name="buscar_historias")
     * @Template("FrontendBundle:Default:inicio.html.twig")
     */
    public function buscarHistoriasAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $fecha  = new \DateTime();
        
        $mes = $request->query->get('month',$fecha->format('m'));
        $year = $request->query->get('year',$fecha->format('Y'));
        
        $historias = $em->getRepository('HistoriasBundle:Historia')
                        ->findHistorias($request->query->get('buscarHistorias'),$this->getUser());
        
        $historiasPorMes = $em->getRepository('HistoriasBundle:Historia')
                              ->getCountHistoriasEnYears($year,$this->getUser());
        
        $meses = $this->getHistoriasPorMesParser($historiasPorMes);
       
        $form = $this->createForm(new HistoriaFrontendType(), new Historia(),array(
            'action' => $this->generateUrl('crear_historia'),
            'method' => 'POST',
            'attr'=>array('id'=>'formCrearHistoria'),
            'usuario'=>$this->getUser(),
        ));
        
        return array(
            'yearActual'    =>  $year,
            'meses'         =>  $meses,
            'historias'     =>  $historias,
            'form'          =>  $form->createView(),
        );
    }
    
    /**
     * @Route("/inicio",name="homepage")
     * @Template()
     */
    public function inicioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $fecha  = new \DateTime();
        
        $mes = $request->query->get('month',$fecha->format('m'));
        $year = $request->query->get('year',$fecha->format('Y'));
        
        $historias = $em->getRepository('HistoriasBundle:Historia')
                        ->getHistoriasDelMes($year,$mes,$this->getUser());
        
        $historiasPorMes = $em->getRepository('HistoriasBundle:Historia')
                              ->getCountHistoriasEnYears($year,$this->getUser());
        
        $meses = $this->getHistoriasPorMesParser($historiasPorMes);
       
        $form = $this->createForm(new HistoriaFrontendType(), new Historia(),array(
            'action' => $this->generateUrl('crear_historia'),
            'method' => 'POST',
            'attr'=>array('id'=>'formCrearHistoria'),
            'usuario'=>$this->getUser(),
        ));
        
        return array(
            'yearActual'    =>  $year,
            'meses'         =>  $meses,
            'historias'     =>  $historias,
            'form'          =>  $form->createView(),
        );
    }
    
    /**
     * @Route("/crear/historia",name="crear_historia")
     * @Template()
     * @Method({"GET","POST"})
     */
    public function crearHistoriaAction(Request $request)
    {
        $historia = new Historia();
        $historia->setUsuario($this->getUser());
        $historia->setFecha(new \DateTime());
        $form = $this->createForm(new HistoriaFrontendType(), new Historia(),array(
            'action' => $this->generateUrl('crear_historia'),
            'method' => 'POST',
            'attr'=>array('id'=>'formCrearHistoria'),
            'usuario'=>$this->getUser(),
        ));
        $isNew = true;
        if($request->isMethod('POST')){
            //$parametros = $request->request->all();
            $form->handleRequest($request);
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $historia = $form->getData();
                $historia->setUsuario($this->getUser());
                $em->persist($historia);
                $em->flush();
                $historia->setClave(md5($historia->getId()));
                $em->flush();
                if($request->isXmlHttpRequest()){
                    $response = new JsonResponse(array(
                        'id'=>$historia->getId(),
                    ));
                    return $response;
                }else{
                    return $this->redirect($this->generateUrl('editar_historia',array('id'=>$historia->getId())));
                }
            }
        }
        
        if($request->isXmlHttpRequest()){
            return $this->render('FrontendBundle:Default:form.html.twig',array(
                'form'=>$form->createView(),
            ));
        }
        
        return array(
            'form'      =>  $form->createView(),
            'historia'  =>  $historia,
            'isNew'     =>  true,
        );
    }
	
	/**
     * @Route("/editar/historia/{id}",name="editar_historia")
     * @Template()
     * @Method({"GET","POST"})
     */
    public function editarHistoriaAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $historia = $em->getRepository('HistoriasBundle:Historia')->find($id);
        if (!$historia) {
            return $this->redirect($this->generateUrl('homepage'));
        }

        return array(
            'historia' => $historia,
        );
    }
    
    /**
     * @Route("/recuperar",name="recuperar")
     * @Template()
     * @Method({"GET","POST"})
     */
    public function recuperarAction(Request $request)
    {   
        $sPassword = "";
        $sUsuario = "";
        $msg = "";
        if($request->isMethod('POST')){
            $email = $request->get('email');
            $usuario = $this->getDoctrine()->getRepository('UsuariosBundle:Usuario')
                            ->findOneBy(array('email'=>$email));
            if(!$usuario){
                $this->get('session')->getFlashBag()->add(
                    'error',
                    'El email no esta registrado.'
                );
                return $this->redirect($this->generateUrl('recuperar'));
            }else{
                $sPassword = substr(md5(time()), 0, 7);
                $sUsuario = $usuario->getUsername();
                $encoder = $this->get('security.encoder_factory')
                            ->getEncoder($usuario);
                $passwordCodificado = $encoder->encodePassword(
                            $sPassword, $usuario->getSalt()
                );
                $usuario->setPassword($passwordCodificado);
                $this->getDoctrine()->getManager()->flush();
                
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'Se ha enviado un correo con la nueva contraseña.'
                );
                
                $this->enviarRecuperar($sUsuario, $sPassword, $usuario);
                $msg = "Te llegara un mail con detalle de tu cuenta";   
            }
        }

        return array('msg'=>$msg);
    }
    
    /**
     * @Route("/registro",name="registro")
     * @Template()
     * @Method({"GET","POST"})
     */
    public function registroAction(Request $request)
    {
        $usuario = new Usuario();
        $form = $this->createForm( new UsuarioFrontendType(), $usuario);
        $isNew = true;
        if($request->isMethod('POST')){
            $parametros = $request->request->all();
            $form->handleRequest($request);
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $this->setSecurePassword($usuario);
                $rolUsuario = $em->getRepository('UsuariosBundle:Roles')
                                 ->findOneBy(array('nombre'=>'ROLE_USUARIO'));
                $usuario->addRol($rolUsuario);
                $em->persist($usuario);
                $em->flush();
                $cont = $this->crearHijos($usuario, $paremetros['ninos'], $parametros['ninas']);
                
                if($cont > 0 ){
                    $this->get('session')->getFlashBag()->add(
                        'notice',
                        'Ahora entra para crear tus historias y editar tus hijos.'
                    );
                    return $this->redirect($this->generateUrl('login'));
                }else{
                    $this->get('session')->getFlashBag()->add(
                        'notice',
                        'Ahora entra para crear tus historias.'
                    );
                    return $this->redirect($this->generateUrl('login'));
                }
            }
        }
        
        return array(
            'form'      =>  $form->createView(),
            'titulo'    => 'Registro',
            'usuario'   => $usuario,
            'isNew'     =>  true,
        );
    }
    
    /**
     * @Route("/editar",name="editar_usuario")
     * @Template("FrontendBundle:Default:registro.html.twig")
     * @Method({"GET","POST"})
     */
    public function editarAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $usuario = $this->getUser();
        if (!$usuario) {
            return $this->redirect($this->generateUrl('login'));
        }
        $form = $this->createForm( new UsuarioFrontendType(), $usuario);
        $isNew = false;
        if($request->isMethod('POST')){
            //obtiene la contraseña
            $current_pass = $usuario->getPassword();
			
            $form->handleRequest($request);
			
            if($form->isValid()){
                
                if (null == $usuario->getPassword()) {
                    // La tienda no cambia su contraseña, utilizar la original
                    $usuario->setPassword($current_pass);
                } else {
                    // actualizamos la contraseña
                    $this->setSecurePassword($usuario);
                }
                $em->flush();
                
            }
        }
        
        return array(
            'form'      =>  $form->createView(),
            'usuario'   =>  $usuario,
            'titulo'    => 'Editar registro',
            'isNew'     =>  $isNew,
        );
    }
    
    /**
     * @Route("/registro/hijos",name="registro_hijos")
     * @Route("/registro/hijos/{id}",name="editar_hijos",requirements={"id": "\d+"})
     * @Template()
     * @Method({"GET","POST"})
     */
    public function registroHijosAction(Request $request,$id = 0)
    {
        $em = $this->getDoctrine()->getManager();
        if($id > 0){
            $hijo = $em->getRepository('UsuariosBundle:Hijo')->find($id);
            $isNew = false;
        }else{
            $hijo = new Hijo();
            $es = $request->query->get('es',  Hijo::INDEFINIDO);
            $hijo->setSexo($es);
            $isNew = true;
        }
        $usuario = $this->getUser();
        if (!$usuario) {
            return $this->redirect($this->generateUrl('login'));
        }
        
        $form = $this->createForm( new HijoFrontendType(), $hijo, array(
            'action' => $this->generateUrl('registro_hijos', array('id' => $hijo->getId())),
            'method' => 'POST',
            'em'=>$this->getDoctrine()->getManager(),
        ));
        
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $hijo->setPapa($this->getUser());
                if($isNew){
                    $em->persist($hijo);
                }
                $em->flush();
                if($isNew){
                    return $this->redirect($this->generateUrl('editar_usuario'));
                }else{
                    return $this->redirect($this->generateUrl('editar_hijos',array('id'=>$hijo->getId())));
                }
                
            }
        }
        
        if($isNew){
            $titulo = ($es <= Hijo::NINO?'Registro niño':'Reistro niña');
        }else{
            $titulo = ($hijo->getSexo() <= Hijo::NINO?'Editar registro niño':'Editar registro niña');
        }
        
        return array(
            'form'  =>  $form->createView(),
            'titulo' => $titulo,
            'hijo'  =>  $hijo,
            'isNew' =>  $isNew,
        );
    }
    
	
    /**
     * @Route("/login", name="login")
     * @Template()
     */
    
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        // obtiene el error de inicio de sesión si lo hay
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render(
            'FrontendBundle:Default:login.html.twig',
            array(
                // último nombre de usuario ingresado
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
            )
        );
    }
	
    /**
     * @Route("/login_check", name="login_check")
     */
    public function securityCheckAction()
    {
        // The security layer will intercept this request
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        // The security layer will intercept this request
    }
    
    private function setSecurePassword(&$entity) {
        $encoder = $this->get('security.encoder_factory')->getEncoder($entity);
        $passwordCodificado = $encoder->encodePassword(
                    $entity->getPassword(),
                    $entity->getSalt()
        );
        $entity->setPassword($passwordCodificado);
    }
    
    private function enviarRecuperar($sUsuario, $sPassword, Usuario $usuario, $isNew = false) {
        $asunto = 'Se ha reestablecido su contraseña';
        $message = \Swift_Message::newInstance()
                ->setSubject($asunto)
                ->setFrom('noreply@babystory.com')
                ->setTo($usuario->getEmail())
                ->setBody(
                        $this->renderView('FrontendBundle:Default:enviarRegistro.html.twig', 
                                compact('usuario','sUsuario','sPassword','isNew','asunto')), 
                                'text/html'
                        );
        $this->get('mailer')->send($message);
    }
    
    private function crearHijos(Usuario $usuario, $ninos, $ninas){
        $cont = ($ninos + $ninas);
        $arreglo = array();
        for ($i = 0; $i < $cont; $i++) {
            if (($ninos - 1) > 0) {
                $nino = new Hijo();
                $nino->setPapa($usuario);
                $nino->setApodo("Niño " + $i);
                $nino->setSexo(Hijo::NINO);
                $em->persist($nino);
                $em->flush();
                $ninos -= 1;
            } else if (($ninas - 1) > 0) {
                $nino = new Hijo();
                $nino->setPapa($usuario);
                $nino->setApodo("Niña " + ($ninas - $i));
                $nino->setSexo(Hijo::NINA);
                $em->persist($nino);
                $em->flush();
                $ninas -= 1;
            }
        }
        return $cont;
    }
 
    private function getHistoriasPorMesParser($mesesHistorias){
        $meses = array(
            0=>array('nombre'=>'Sin mes','historias'=>0),
            1=>array('nombre'=>'Enero','historias'=>0),
            2=>array('nombre'=>'Febrero','historias'=>0),
            3=>array('nombre'=>'Marzo','historias'=>0),
            4=>array('nombre'=>'Abril','historias'=>0),
            5=>array('nombre'=>'Mayo','historias'=>0),
            6=>array('nombre'=>'Junio','historias'=>0),
            7=>array('nombre'=>'Julio','historias'=>0),
            8=>array('nombre'=>'Agosto','historias'=>0),
            9=>array('nombre'=>'Septiembre','historias'=>0),
            10=>array('nombre'=>'Octubre','historias'=>0),
            11=>array('nombre'=>'Noviembre','historias'=>0),
            12=>array('nombre'=>'Diciembre','historias'=>0),
        );
        
        foreach($mesesHistorias as $key => $registro){
            $meses[$key]['historias']=$registro['cuantas'];
        }
        
        return $meses;
    }
    
    /**
     * @Route("/dialogo/papa/{id}",name="dialogo_papa")
     * @Method({"GET","POST"})
     */
    public function getDialogoPapa(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $historia = $em->getRepository('HistoriasBundle:Historia')->find($id);
        $componente = new Componente();
        
        $componente->setTipo(Componente::TIPO_DIALOGO);
        $componente->setTipoUsuario(Componente::TIPO_USUARIO_PAPA);
        $componente->setHistoria($historia);
        $componente->setPapa($this->getUser());
        
        $max = $em->getRepository('HistoriasBundle:Componente')->getMaxPosicion($historia->getId());
        if($max == null){
            $max=0;
        }
        $componente->setPosition($max+1);
        
        $form = $this->createFormBuilder($componente)
            ->add('componente', 'textarea',array('label'=>'Dialogo','attr'=>array('class'=>'form-control')))
            ->getForm();
        
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isValid()){
                $em->persist($componente);
                $em->flush();
                $response = new JsonResponse(json_encode(array(
                    'html'=>$this->renderView('FrontendBundle:Default:dialogoPapa.html.twig', array('componente'=>$componente)),
                    'respuesta'=>'creado',
                )));
                return $response;
            }
        }
        
        $response = new JsonResponse(json_encode(array(
            'form' => $this->renderView('FrontendBundle:Default:formComponente.html.twig', array(
                'rutaAction' => $this->generateUrl('dialogo_papa',array('id'=>$historia->getId())),
                'form'=>$form->createView(),
             )),
            'respuesta' => 'nuevo',
        )));
        return $response;
    }
    
    /**
     * @Route("/dialogo/nino/{id}",name="dialogo_nino")
     * @Method({"GET","POST"})
     */
    public function getDialogoNino(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $historia = $em->getRepository('HistoriasBundle:Historia')->find($id);
        $componente = new Componente();
        
        $componente->setTipo(Componente::TIPO_DIALOGO);
        $componente->setTipoUsuario(Componente::TIPO_USUARIO_HIJO);
        $componente->setHistoria($historia);
        $componente->setPapa($this->getUser());
        $componente->setHijo($historia->getHijo());
        
        $max = $em->getRepository('HistoriasBundle:Componente')->getMaxPosicion($historia->getId());
        if($max == null){
            $max=0;
        }
        $componente->setPosition($max+1);
        
        $form = $this->createFormBuilder($componente)
            ->add('hijo', null,array('label'=>'Niño(a)','attr'=>array('class'=>'form-control')))
            ->add('componente', 'textarea',array('label'=>'Dialogo','attr'=>array('class'=>'form-control')))
            ->getForm();
        
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isValid()){
                $em->persist($componente);
                $em->flush();
                $response = new JsonResponse(json_encode(array(
                    'html'=>$this->renderView('FrontendBundle:Default:dialogoNino.html.twig', array('componente'=>$componente)),
                    'respuesta'=>'creado',
                )));
                return $response;
            }
        }
        
        $response = new JsonResponse(json_encode(array(
            'form' => $this->renderView('FrontendBundle:Default:formComponente.html.twig', array(
                'rutaAction' => $this->generateUrl('dialogo_nino',array('id'=>$historia->getId())),
                'form'=>$form->createView(),
             )),
            'respuesta' => 'nuevo',
        )));
        return $response;
    }
    
    /**
     * @Route("/imagen/nino/{id}",name="imagen_nino")
     * @Method({"GET","POST"})
     */
    public function getImagenNino(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $historia = $em->getRepository('HistoriasBundle:Historia')->find($id);
        $componente = new Componente();
        
        $componente->setTipo(Componente::TIPO_IMAGEN);
        $componente->setTipoUsuario(Componente::TIPO_USUARIO_PAPA);
        $componente->setHistoria($historia);
        $componente->setPapa($this->getUser());
        
        $max = $em->getRepository('HistoriasBundle:Componente')->getMaxPosicion($historia->getId());
        if($max == null){
            $max=0;
        }
        $componente->setPosition($max+1);
        
        $form = $this->createFormBuilder($componente)
            ->add('file', 'file',array('label'=>'Imagen','attr'=>array('class'=>'form-control')))
            ->add('componente', 'hidden')
            ->getForm();
        
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isValid()){
                $em->persist($componente);
                $em->flush();
                /*$response = new JsonResponse(json_encode(array(
                    'html'=>$this->renderView('FrontendBundle:Default:imagenNino.html.twig', array('componente'=>$componente)),
                    'respuesta'=>'creado',
                )));
                return $response;*/
                return $this->redirect($this->generateUrl('editar_historia',array('id'=>$historia->getId())));
            }
        }
        
        $response = new JsonResponse(json_encode(array(
            'form' => $this->renderView('FrontendBundle:Default:formComponente.html.twig', array(
                'rutaAction' => $this->generateUrl('imagen_nino',array('id'=>$historia->getId())),
                'form'=>$form->createView(),
             )),
            'respuesta' => 'nuevo',
        )));
        return $response;
    }
    
    /**
     * @Route("/sonido/nino/{id}",name="sonido_nino")
     * @Method({"GET","POST"})
     */
    public function getSonidoNino(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $historia = $em->getRepository('HistoriasBundle:Historia')->find($id);
        $componente = new Componente();
        
        $componente->setTipo(Componente::TIPO_MUSICA);
        $componente->setTipoUsuario(Componente::TIPO_USUARIO_PAPA);
        $componente->setHistoria($historia);
        $componente->setPapa($this->getUser());
        
        $max = $em->getRepository('HistoriasBundle:Componente')->getMaxPosicion($historia->getId());
        if($max == null){
            $max=0;
        }
        $componente->setPosition($max+1);
        
        $form = $this->createFormBuilder($componente)
            ->add('file', 'file',array('label'=>'Sonido (mp3)','attr'=>array('class'=>'form-control')))
            ->add('componente', 'hidden')
            ->getForm();
        
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isValid()){
                $em->persist($componente);
                $em->flush();
                /*$response = new JsonResponse(json_encode(array(
                    'html'=>$this->renderView('FrontendBundle:Default:sonidoNino.html.twig', array('componente'=>$componente)),
                    'respuesta'=>'creado',
                )));
                return $response;*/
                return $this->redirect($this->generateUrl('editar_historia',array('id'=>$historia->getId())));
            }
        }
        
        $response = new JsonResponse(json_encode(array(
            'form' => $this->renderView('FrontendBundle:Default:formComponente.html.twig', array(
                'rutaAction' => $this->generateUrl('sonido_nino',array('id'=>$historia->getId())),
                'form'=>$form->createView(),
             )),
            'respuesta' => 'nuevo',
        )));
        return $response;
    }
    
    /**
     * @Route("/video/link/nino/{id}",name="video_link_nino")
     * @Method({"GET","POST"})
     */
    public function getVideoLinkNino(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $historia = $em->getRepository('HistoriasBundle:Historia')->find($id);
        $componente = new Componente();
        
        $componente->setTipo(Componente::TIPO_LINK);
        $componente->setTipoUsuario(Componente::TIPO_USUARIO_PAPA);
        $componente->setHistoria($historia);
        $componente->setPapa($this->getUser());
        
        $max = $em->getRepository('HistoriasBundle:Componente')->getMaxPosicion($historia->getId());
        if($max == null){
            $max=0;
        }
        $componente->setPosition($max+1);
        
        $form = $this->createFormBuilder($componente)
            ->add('componente','text',array('label'=>'Link (youtube)','attr'=>array('class'=>'form-control')))
            ->getForm();
        
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isValid()){
                $parametros = $request->request->all();
                $video = RpsStms::getTitleAndImageVideoYoutube($parametros['form']['componente']);
                $componente->setComponente($video['urlVideo']);
                $em->persist($componente);
                $em->flush();
                $response = new JsonResponse(json_encode(array(
                    'html'=>$this->renderView('FrontendBundle:Default:videoNino.html.twig', array('componente'=>$componente)),
                    'respuesta'=>'creado',
                )));
                return $response;
            }
        }
        
        $response = new JsonResponse(json_encode(array(
            'form' => $this->renderView('FrontendBundle:Default:formComponente.html.twig', array(
                'rutaAction' => $this->generateUrl('video_link_nino',array('id'=>$historia->getId())),
                'form'=>$form->createView(),
             )),
            'respuesta' => 'nuevo',
        )));
        return $response;
    }
    
    /**
     * @Route("/agregar/comentario/{id}",name="comentario_historia")
     * @Method({"GET","POST"})
     */
    public function agregarComentarioHistoria(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $historia = $em->getRepository('HistoriasBundle:Historia')->find($id);
        $comentario = new Comentario();
        
        $form = $this->createFormBuilder($comentario)
            ->add('comentario','text',array('label'=>'Comentario','attr'=>array('class'=>'form-control')))
            ->add('calificacion',null,array('label'=>'Calificacion','attr'=>array('class'=>'form-control')))    
            ->getForm();
        
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isValid()){
                $comentario = $form->getData();
                $comentario->setHistoria($historia);
                $comentario->setUsuario($this->getUser());
                $em->persist($comentario);
                $em->flush();
                $response = new JsonResponse(json_encode(array(
                    'html'=>$this->renderView('FrontendBundle:Default:comentario.html.twig', array('comentario'=>$comentario)),
                    'respuesta'=>'creado',
                )));
                return $response;
            }
        }
        
        $response = new JsonResponse(json_encode(array(
            'form' => $this->renderView('FrontendBundle:Default:formComponente.html.twig', array(
                'rutaAction' => $this->generateUrl('comentario_historia',array('id'=>$historia->getId())),
                'form'=>$form->createView(),
             )),
            'respuesta' => 'nuevo',
        )));
        return $response;
    }
}
