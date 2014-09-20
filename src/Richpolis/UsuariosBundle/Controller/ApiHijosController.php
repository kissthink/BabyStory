<?php

namespace Richpolis\UsuariosBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Richpolis\UsuariosBundle\Entity\Hijo;
use Richpolis\FrontendBundle\Controller\ApiBaseController;
use Doctrine\ORM\Query;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/api/hijos")
 */
class ApiHijosController extends ApiBaseController
{
    /**
     * @Route("/", name="api_get_usuarios")
     * @Method({"GET"})
     */
    public function listAction()
    {
        return parent::listAction();
    }

    /**
     * @Route("/{id}", name="api_get_usuario")
     * @Method({"GET"})
     */
    public function readAction($id)
    {
        return parent::readAction($id);
    }
    
    /**
     * @Route("/{id}/hijos", name="api_get_hijos_usuario")
     * @Method({"GET"})
     */
    public function getHijosAction($id)
    {
        return new JsonResponse($this->getHijosForJson($id));
    }

    /**
     * @Route("/", name="api_post_usuarios")
     * @Method({"POST"})
     */
    public function createAction()
    {
        $json = $this->getJsonFromRequest();
        if (false === $json) {
            throw new \Exception('Invalid JSON');
        }

        $object = $this->updateEntity($this->getNewEntity(), $json);
        if (false === $object) {
            throw new \Exception('Unable to create the entity');
        }

        $em = $this->getDoctrine()->getManager();
        $this->setSecurePassword($object);
        $em->persist($object);
        $em->flush();

        return new JsonResponse($this->getEntityForJson($object->getId()));
    }
    
    
    /**
     * @Route("/{id}", name="api_put_usuarios")
     * @Method({"PUT"})
     */
    public function updateAction($id)
    {
        $object = $this->getEntity($id);
        if (false === $object) {
            return $this->createNotFoundException();
        }
       
        //obtiene la contraseña actual
        $current_pass = $entity->getPassword();

        $json = $this->getJsonFromRequest();
        if (false === $json) {
            throw new \Exception('Invalid JSON');
        }

        if (false === $this->updateEntity($object, $json)) {
            throw new \Exception('Unable to update the entity');
        }
        
        if (null == $object->getPassword()) {
            // La tienda no cambia su contraseña, utilizar la original
            $entity->setPassword($current_pass);
        } else {
            // actualizamos la contraseña
            $this->setSecurePassword($entity);
        }

        $this->getDoctrine()->getManager()->flush($object);

        return new JsonResponse($this->getEntityForJson($object->getId()));
    }

    /**
     * @see ApiBaseController::getRepository()
     * @return EntityRepository
     */
    public function getRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository('UsuariosBundle:Usuario');
    }
    
    /**
     * @see ApiBaseController::getRepositoryHijo()
     * @return EntityRepository
     */
    public function getRepositoryHijo()
    {
        return $this->getDoctrine()->getManager()->getRepository('UsuariosBundle:Hijo');
    }

    /**
     * @see ApiBaseController::getNewEntity()
     * @return Object
     */
    public function getNewEntity()
    {
        return new Usuario();
    }
    
    /**
     * Returns an entity from its ID as an associative array, or FALSE in case of error.
     * 
     * @param int $id
     * @return array|boolean
     */
    protected function getHijosForJson($id) {
        try {
            return $this->getRepositoryHijo()->createQueryBuilder('h,u')
                            ->join('h.papa','u')
                            ->where('u.id = :id')
                            ->setParameter('id', $id)
                            ->getQuery()->getResult(Query::HYDRATE_ARRAY);
        }
        catch (NoResultException $ex) {
            return false;
        }

        return false;
    }
    
    private function setSecurePassword(&$entity) {
        $encoder = $this->get('security.encoder_factory')->getEncoder($entity);
        $passwordCodificado = $encoder->encodePassword(
                    $entity->getPassword(),
                    $entity->getSalt()
        );
        $entity->setPassword($passwordCodificado);
    }
}