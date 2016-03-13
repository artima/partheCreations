<?php

namespace Artimone\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Artimone\BlogBundle\Entity\Gender;
use Artimone\BlogBundle\Form\GenderType;

/**
 * Gender controller.
 *
 */
class GenderController extends Controller
{
    /**
     * Lists all Gender entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $genders = $em->getRepository('ArtimoneBlogBundle:Gender')->findAll();

        return $this->render('gender/index.html.twig', array(
            'genders' => $genders,
        ));
    }

    /**
     * Creates a new Gender entity.
     *
     */
    public function newAction(Request $request)
    {
        $gender = new Gender();
        $form = $this->createForm('Artimone\BlogBundle\Form\GenderType', $gender);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($gender);
            $em->flush();

            return $this->redirectToRoute('gender_show', array('id' => $gender->getId()));
        }

        return $this->render('gender/new.html.twig', array(
            'gender' => $gender,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Gender entity.
     *
     */
    public function showAction(Gender $gender)
    {
        $deleteForm = $this->createDeleteForm($gender);

        return $this->render('gender/show.html.twig', array(
            'gender' => $gender,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Gender entity.
     *
     */
    public function editAction(Request $request, Gender $gender)
    {
        $deleteForm = $this->createDeleteForm($gender);
        $editForm = $this->createForm('Artimone\BlogBundle\Form\GenderType', $gender);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($gender);
            $em->flush();

            return $this->redirectToRoute('gender_edit', array('id' => $gender->getId()));
        }

        return $this->render('gender/edit.html.twig', array(
            'gender' => $gender,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Gender entity.
     *
     */
    public function deleteAction(Request $request, Gender $gender)
    {
        $form = $this->createDeleteForm($gender);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($gender);
            $em->flush();
        }

        return $this->redirectToRoute('gender_index');
    }

    /**
     * Creates a form to delete a Gender entity.
     *
     * @param Gender $gender The Gender entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Gender $gender)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gender_delete', array('id' => $gender->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
