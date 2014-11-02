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
//use Symfony\Component\Form\CallbackValidator;
//use Symfony\Component\Form\FormInterface;
//use Symfony\Component\Form\FormError;

use Oxigeno\Extranet\PacienteBundle\Form\PersonaType;

/**
 * Description of UsuarioType
 *
 * @author francisco
 */
class UsuarioType extends AbstractType {
    
    public function getName() {
        return 'oxigeno_seguridadbundle_usuariotype';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('nombre')
                ->add('password', 'repeated', array(
                    'type' => 'password', 
                    'required' => false,
                    'first_options' => array('label' => 'Contraseña'), 
                    'second_options' => array('label' => 'Repita su contraseña'), 
                ))
                ->add('email')
                ->add('persona', new PersonaType(), array(
                    'required' => true
                ))
            ;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Oxigeno\Extranet\SeguridadBundle\Entity\Usuario'
        ));
    }
}
