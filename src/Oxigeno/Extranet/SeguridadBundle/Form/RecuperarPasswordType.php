<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Oxigeno\Extranet\SeguridadBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of RecuperarPasswordType
 *
 * @author francisco
 */
class RecuperarPasswordType extends AbstractType {
    
    public function getName() {
        return 'oxigeno_seguridadbundle_recuperarpasswordtype';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('password', 'repeated', array(
                    'type' => 'password', 
                    'required' => true,
                    'first_options' => array('label' => 'Contraseña'), 
                    'second_options' => array('label' => 'Repita su contraseña'), 
                ))
            ;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Oxigeno\Extranet\SeguridadBundle\Entity\Usuario'
        ));
    }
}
