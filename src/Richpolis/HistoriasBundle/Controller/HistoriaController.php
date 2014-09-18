<?php

namespace Richpolis\HistoriasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Richpolis\HistoriasBundle\Entity\Historia;
use Richpolis\HistoriasBundle\Form\HistoriaType;

/**
 * Historia controller.
 *
 * @Route("/admin/historias")
 */
class HistoriaController extends Controller
{

    /**
     * Lists all Historia entities.
     *
     * @Route("/", name="historias")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $buscar = $request->get('buscar','');
        if(strlen($buscar)>0){
                $options = array('filterParam'=>'buscar','filterValue'=>$buscar);
        }else{
                $options = array();
        }
        $query = $em->getRepository('HistoriasBundle:Historia')->queryFindHistorias($buscar);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, $this->get('request')->query->get('page', 1),10, $options 
        );

        return compact('pagination');
    }
    /**
     * Creates a new Historia entity.
     *
     * @Route("/", name="historias_create")
     * @Method("POST")
     * @Template("HistoriasBundle:Historia:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Historia();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('historias_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Historia entity.
     *
     * @param Historia $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Historia $entity)
    {
        $form = $this->createForm(new HistoriaType(), $entity, array(
            'action' => $this->generateUrl('historias_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Historia entity.
     *
     * @Route("/new", name="historias_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Historia();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Historia entity.
     *
     * @Route("/{id}", name="historias_show", requirements={"id": "\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HistoriasBundle:Historia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Historia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Historia entity.
     *
     * @Route("/{id}/edit", name="historias_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HistoriasBundle:Historia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Historia entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Historia entity.
    *
    * @param Historia $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Historia $entity)
    {
        $form = $this->createForm(new HistoriaType(), $entity, array(
            'action' => $this->generateUrl('historias_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Historia entity.
     *
     * @Route("/{id}", name="historias_update")
     * @Method("PUT")
     * @Template("HistoriasBundle:Historia:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HistoriasBundle:Historia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Historia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('historias_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Historia entity.
     *
     * @Route("/{id}", name="historias_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('HistoriasBundle:Historia')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Historia entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('historias'));
    }

    /**
     * Creates a form to delete a Historia entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('historias_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete','attr'=>array('class'=>'btn btn-danger')))
            ->getForm()
        ;
    }
    
    /**
     * Exporta la lista completa de usuarios.
     *
     * @Route("/exportar", name="historias_export")
     * @Method("GET")
     */
    public function exportarAction() {
        $historias = $this->getDoctrine()
                ->getRepository('HistoriasBundle:Historia')
                ->findHistorias();

        $response = $this->render(
                'HistoriasBundle:Historia:list.xls.twig', array('historias' => $historias)
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="export-historias.xls"');
        return $response;
    }
}
