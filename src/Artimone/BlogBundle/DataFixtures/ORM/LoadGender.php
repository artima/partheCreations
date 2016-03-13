<?php
// src/Artimone/Blog/DataFixtures/ORM/LoadGender.php

namespace Artimone\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Artimone\BlogBundle\Entity\Gender;

class LoadGender implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de genre à ajouter
    $names = array(
      'Développement web',
      'Développement mobile',
      'Graphisme',
      'Intégration',
      'Réseau'
    );

    foreach ($names as $name) {
      // On crée le genre
      $gender = new Gender();
      $gender->setName($name);

      // On la persiste
      $manager->persist($gender);
    }

    // On déclenche l'enregistrement de toutes les genre
    $manager->flush();
  }
}