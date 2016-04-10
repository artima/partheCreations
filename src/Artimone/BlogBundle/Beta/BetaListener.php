<?php
// src/Artimone/BlogBundle/Beta/BetaListener.php

namespace Artimone\BlogBundle\Beta;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class BetaListener
{
  // Notre processeur
  protected $betaHTML;

  // La date de fin de la version bêta :
  // - Avant cette date, on affichera un compte à rebours (J-3 par exemple)
  // - Après cette date, on n'affichera plus le « bêta »
  protected $endDate;

  public function __construct(BetaHTML $betaHTML, $endDate)
  {
    $this->betaHTML = $betaHTML;
    $this->endDate  = new \Datetime($endDate);
  }

  public function processBeta(FilterResponseEvent $event)
  {
    if (!$event->isMasterRequest()) {
      return;
    }

    $remainingDays = $this->endDate->diff(new \Datetime())->format('%m mois et %d jour(s)');

    // Si la date est dépassée, on ne fait rien
    if ($this->endDate <= new \Datetime()) {
      return;
    }

    // On utilise notre BetaHRML
    $response = $this->betaHTML->displayBeta($event->getResponse(), $remainingDays);
    // On met à jour la réponse avec la nouvelle valeur
    $event->setResponse($response);
  }
}