<?php

namespace Artimone\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AnnonceController extends Controller
{
    public function indexAction($page)
    {
         if ($page < 1) {
            throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
        }
        return $this->render('ArtimoneBlogBundle:Annonce:index.html.twig');
    }
    
    public function showAction($id)
    {
        return $this->render('ArtimoneBlogBundle:Annonce:show.html.twig', array('id' => $id));
    }
    
    public function newAction(Request $request)
    {
        // On récupère le service
        $antispam = $this->container->get('artimone_blog.antispam');
    
        $text = '...';
        if ($antispam->isSpam($text)) {
          throw new \Exception('Votre message a été détecté comme spam !');
        }
        if ($request->isMethod('POST')) {
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            return $this->redirectToRoute('artimone_blog_show', array('id' => 5));
        }
        return $this->render('ArtimoneBlogBundle:Annonce:new.html.twig');
    }
    
    public function editAction($id, Request $request)
    {
        if ($request->isMethod('POST')) {
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');
            return $this->redirectToRoute('artimone_blog_show', array('id' => $id));
        }
        return $this->render('ArtimoneBlogBundle:Annonce:edit.html.twig', array('id' => $id));
    }
    
    public function deleteAction($id)
    {
        return $this->render('ArtimoneBlogBundle:Annonce:delete.html.twig', array('id' => $id));
    }
}
