<?php

namespace Artimone\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GeneralController extends Controller
{
    public function indexAction()
    {
        return $this->render('ArtimoneGeneralBundle:General:index.html.twig');
    }
}
