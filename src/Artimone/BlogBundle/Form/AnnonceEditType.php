<?php

namespace Artimone\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder->remove('date');
    }

    public function getName()
    {
      return 'artimone_blogbundle_annonce_edit';
    }
    
    public function getParent()
    {
      return new AnnonceType();
    }
}
