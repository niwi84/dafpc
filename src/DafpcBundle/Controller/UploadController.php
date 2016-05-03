<?php

namespace DafpcBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use DafpcBundle\Entity\Upload;
use DafpcBundle\Form\UploadType;

/**
 * Upload controller.
 *
 */
class UploadController extends Controller
{
    // deplacement fichier
    public function createAction()
    {
        $entity  = new Job();
        $request = $this->getRequest();
        $form    = $this->createForm(new JobType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ens_job_show', array(
                'company' => $entity->getCompanySlug(),
                'location' => $entity->getLocationSlug(),
                'id' => $entity->getId(),
                'position' => $entity->getPositionSlug()
            )));
        }

        return $this->render('DafpcBundle:upload:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }
    //

    /**
     * Lists all Upload entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $uploads = $em->getRepository('DafpcBundle:Upload')->findAll();

        return $this->render('DafpcBundle:upload:index.html.twig', array(
            'uploads' => $uploads,
        ));
    }

    /**
     * Creates a new Upload entity.
     *
     */
    public function newAction(Request $request)
    {
        $upload = new Upload();
        $form = $this->createForm('DafpcBundle\Form\UploadType', $upload);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($upload);
            $em->flush();

            return $this->redirectToRoute('upload_show', array('id' => $upload->getId()));
        }

        return $this->render('DafpcBundle:upload:new.html.twig', array(
            'upload' => $upload,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Upload entity.
     *
     */
    public function showAction(Upload $upload)
    {
        $deleteForm = $this->createDeleteForm($upload);

        return $this->render('DafpcBundle:upload:show.html.twig', array(
            'upload' => $upload,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Upload entity.
     *
     */
    public function editAction(Request $request, Upload $upload)
    {
        $deleteForm = $this->createDeleteForm($upload);
        $editForm = $this->createForm('DafpcBundle\Form\UploadType', $upload);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($upload);
            $em->flush();

            return $this->redirectToRoute('upload_edit', array('id' => $upload->getId()));
        }

        return $this->render('DafpcBundle:upload:edit.html.twig', array(
            'upload' => $upload,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Upload entity.
     *
     */
    public function deleteAction(Request $request, Upload $upload)
    {
        $form = $this->createDeleteForm($upload);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($upload);
            $em->flush();
        }

        return $this->redirectToRoute('upload_index');
    }

    /**
     * Creates a form to delete a Upload entity.
     *
     * @param Upload $upload The Upload entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Upload $upload)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('upload_delete', array('id' => $upload->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
