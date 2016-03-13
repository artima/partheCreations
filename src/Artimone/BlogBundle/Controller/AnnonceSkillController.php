<?php

namespace Artimone\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Artimone\BlogBundle\Entity\AnnonceSkill;
use Artimone\BlogBundle\Form\AnnonceSkillType;

/**
 * AnnonceSkill controller.
 *
 */
class AnnonceSkillController extends Controller
{
    /**
     * Lists all AnnonceSkill entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $annonceSkills = $em->getRepository('ArtimoneBlogBundle:AnnonceSkill')->findAll();

        return $this->render('annonceskill/index.html.twig', array(
            'annonceSkills' => $annonceSkills,
        ));
    }

    /**
     * Creates a new AnnonceSkill entity.
     *
     */
    public function newAction(Request $request)
    {
        $annonceSkill = new AnnonceSkill();
        $form = $this->createForm('Artimone\BlogBundle\Form\AnnonceSkillType', $annonceSkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($annonceSkill);
            $em->flush();

            return $this->redirectToRoute('annonceskill_show', array('id' => $annonceSkill->getId()));
        }

        return $this->render('annonceskill/new.html.twig', array(
            'annonceSkill' => $annonceSkill,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a AnnonceSkill entity.
     *
     */
    public function showAction(AnnonceSkill $annonceSkill)
    {
        $deleteForm = $this->createDeleteForm($annonceSkill);

        return $this->render('annonceskill/show.html.twig', array(
            'annonceSkill' => $annonceSkill,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing AnnonceSkill entity.
     *
     */
    public function editAction(Request $request, AnnonceSkill $annonceSkill)
    {
        $deleteForm = $this->createDeleteForm($annonceSkill);
        $editForm = $this->createForm('Artimone\BlogBundle\Form\AnnonceSkillType', $annonceSkill);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($annonceSkill);
            $em->flush();

            return $this->redirectToRoute('annonceskill_edit', array('id' => $annonceSkill->getId()));
        }

        return $this->render('annonceskill/edit.html.twig', array(
            'annonceSkill' => $annonceSkill,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a AnnonceSkill entity.
     *
     */
    public function deleteAction(Request $request, AnnonceSkill $annonceSkill)
    {
        $form = $this->createDeleteForm($annonceSkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($annonceSkill);
            $em->flush();
        }

        return $this->redirectToRoute('annonceskill_index');
    }

    /**
     * Creates a form to delete a AnnonceSkill entity.
     *
     * @param AnnonceSkill $annonceSkill The AnnonceSkill entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AnnonceSkill $annonceSkill)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('annonceskill_delete', array('id' => $annonceSkill->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
