<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Oxigeno\ExtranetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of ArchivoType
 *
 * @author francisco
 */
class ArchivoType extends AbstractType {
    
    public function getName() {
        return 'oxigeno_extranetbundle_archivotype';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('file', 'file', array(
                    'label' => false,                    
                    'empty_data'  => null
                ))
            ;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Oxigeno\ExtranetBundle\Entity\Archivo',
        ));
    }
}
