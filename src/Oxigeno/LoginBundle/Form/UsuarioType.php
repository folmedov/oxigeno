<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Oxigeno\LoginBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Oxigeno\ExtranetBundle\Form\PersonaType;

/**
 * Description of UsuarioType
 *
 * @author francisco
 */
class UsuarioType extends AbstractType {
    
    public function getName() {
        return 'oxigeno_loginbundle_usuariotype';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('nombre')
                ->add('password', 'repeated', array(
                    'type' => 'password', 
                    'first_options' => array('label' => 'Contraseña'), 
                    'second_options' => array('label' => 'Repita su contraseña'), 
                ))
                ->add('email')
                ->add('persona', new PersonaType())
            ;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Oxigeno\LoginBundle\Entity\Usuario'
        ));
    }
}
