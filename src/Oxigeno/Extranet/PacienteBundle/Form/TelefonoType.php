<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Oxigeno\Extranet\PacienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of TelefonoType
 *
 * @author francisco
 */
class TelefonoType extends AbstractType {
    public function getName() {
        return 'oxigeno_extranetpacientebundle_telefonotype';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('numero', 'text', array('required' => false))
            ;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Oxigeno\Extranet\PacienteBundle\Entity\Telefono'
        ));
    }
}
