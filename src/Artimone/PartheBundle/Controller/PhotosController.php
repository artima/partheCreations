<?php

namespace Artimone\PartheBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Artimone\PartheBundle\Entity\Photos;
use Artimone\PartheBundle\Form\PhotosType;

/**
 * Photos controller.
 *
 */
class PhotosController extends Controller
{
    /**
     * Lists all Photos entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $photos = $em->getRepository('ArtimonePartheBundle:Photos')->findAll();

        return $this->render('photos/index.html.twig', array(
            'photos' => $photos,
        ));
    }

    /**
     * Creates a new Photos entity.
     *
     */
    public function newAction(Request $request)
    {
        $photo = new Photos();
        $form = $this->createForm('Artimone\PartheBundle\Form\PhotosType', $photo);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();

            return $this->redirectToRoute('photos_show', array('id' => $photo->getId()));
        }

        return $this->render('photos/new.html.twig', array(
            'photo' => $photo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Photos entity.
     *
     */
    public function showAction(Photos $photo)
    {
        $deleteForm = $this->createDeleteForm($photo);

        return $this->render('photos/show.html.twig', array(
            'photo' => $photo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Photos entity.
     *
     */
    public function editAction(Request $request, Photos $photo)
    {
        $deleteForm = $this->createDeleteForm($photo);
        $editForm = $this->createForm('Artimone\PartheBundle\Form\PhotosType', $photo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();

            return $this->redirectToRoute('photos_edit', array('id' => $photo->getId()));
        }

        return $this->render('photos/edit.html.twig', array(
            'photo' => $photo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Photos entity.
     *
     */
    public function deleteAction(Request $request, Photos $photo)
    {
        $form = $this->createDeleteForm($photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($photo);
            $em->flush();
        }

        return $this->redirectToRoute('photos_index');
    }

    /**
     * Creates a form to delete a Photos entity.
     *
     * @param Photos $photo The Photos entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Photos $photo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('photos_delete', array('id' => $photo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
