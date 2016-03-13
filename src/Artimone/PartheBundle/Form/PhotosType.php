<?php

namespace Artimone\PartheBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhotosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',NULL, array('attr' => array('class' => 'form-control col-lg-6')))
            ->add('descPhoto',NULL, array('attr' => array('class' => 'form-control col-lg-6')))
            ->add('category',NULL, array('attr' => array('class' => 'form-control col-lg-6')))
            ->add('file')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Artimone\PartheBundle\Entity\Photos'
        ));
    }
}
