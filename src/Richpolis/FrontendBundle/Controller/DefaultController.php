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
use Richpolis\UsuariosBundle\Form\UsuarioType;
use Richpolis\UsuariosBundle\Form\HijoType;

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
     * @Route("/inicio",name="homepage")
     * @Template()
     */
    public function inicioAction()
    {
        return array();
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
                $sUsuario = $usuario->getUsuario();
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
        $form = $this->createForm( new UsuarioType(), $usuario);
        $isNew = true;
        if($request->isMethod('POST')){
            $form->handleRequest();
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $this->setSecurePassword($usuario);
                $em->persist($usuario);
                $em->flush();
                $cont = $this->crearHijos($usuario, $request->get('ninos',0), $request->get('ninas',0));
                if($cont > 0 ){
                    return $this->redirect($this->generateUrl('registroHijos'));
                }else{
                    return $this->redirect($this->generateUrl('login'));
                }
            }
        }
        return array(
            'form'  =>  $form->createView(),
            'isNew' =>  true,
        );
    }
    
    /**
     * @Route("/editar",name="editar")
     * @Template("FrontendBundle:Default:registro.html.twig")
     * @Method({"GET","PUT"})
     */
    public function editarAction(Request $request)
    {
        $usuario = $this->getUser();
        $form = $this->createForm( new UsuarioType(), $usuario);
        $isNew = false;
        if($request->isMethod('PUT')){
            $form->handleRequest();
            //obtiene la contraseÃ±a actual -----------------------
            $current_pass = $usuario->getPassword();
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
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
            'form'  =>  $form->createView(),
            'isNew' =>  $isNew,
        );
    }
    
    /**
     * @Route("/registro/hijos",name="registro_hijos")
     * @Template()
     * @Method({"GET","POST"})
     */
    public function registroHijosAction(Request $request)
    {
        $usuario = new Hijo();
        $form = $this->createForm( new UsuarioType(), $usuario);
        $isNew = true;
        if($request->isMethod('POST')){
            $form->handleRequest();
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $this->setSecurePassword($usuario);
                $em->persist($usuario);
                $em->flush();
                $cont = $this->crearHijos($usuario, $request->get('ninos',0), $request->get('ninas',0));
                 
                if($cont > 0 ){
                    return $this->redirect($this->generateUrl('registroHijos'));
                }else{
                    return $this->redirect($this->generateUrl('login'));
                }
            }
        }
        return array(
            'form'  =>  $form->createView(),
            'isNew' =>  true,
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
                $em->persist($nino);
                $em->flush();
                $ninos -= 1;
            } else if (($ninas - 1) > 0) {
                $nino = new Hijo();
                $nino->setPapa($usuario);
                $nino->setApodo("Niña " + ($ninas - $i));
                $em->persist($nino);
                $em->flush();
                $ninas -= 1;
            }
        }
        return $cont;
    }
}
