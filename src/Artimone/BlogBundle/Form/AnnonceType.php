<?php

namespace Artimone\BlogBundle\Form;

use Artimone\BlogBundle\Entity\Image;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AnnonceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class)
            ->add('title', TextType::class)
            ->add('author')
            ->add('content')
            ->add('image', ImageType::class)
            ->add('genders', EntityType::class , array(
                'class'    => 'ArtimoneBlogBundle:Gender',
                'choice_label' => 'name',
                'multiple' => true,
            ))
        ;
        // On ajoute une fonction qui va écouter un évènement
        $builder->addEventListener(
          FormEvents::PRE_SET_DATA,    // 1er argument : L'évènement qui nous intéresse : ici, PRE_SET_DATA
          function(FormEvent $event) { // 2e argument : La fonction à exécuter lorsque l'évènement est déclenché
            // On récupère notre objet Annonce sous-jacent
            $annonce = $event->getData();

            // Cette condition est importante, on en reparle plus loin
            if (null === $annonce) {
              return; // On sort de la fonction sans rien faire lorsque $annonce vaut null
            }

            if (!$annonce->getPublished() || null === $annonce->getId()) {
              // Si l'annonce n'est pas publiée, ou si elle n'existe pas encore en base (id est null),
              // alors on ajoute le champ published
              $event->getForm()->add('published', null, array('required' => false));
            } else {
              // Sinon, on le supprime
              $event->getForm()->remove('published');
            }
          }
        );
    }
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Artimone\BlogBundle\Entity\Annonce'
        ));
    }
}
