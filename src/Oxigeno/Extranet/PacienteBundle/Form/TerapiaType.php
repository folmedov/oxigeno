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
 * Description of TerapiaType
 *
 * @author francisco
 */
class TerapiaType extends AbstractType {
    
    public function getName() {
        return 'oxigeno_extranetpacientebundle_terapiatype';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('fecha_inicio', 'date')
            ;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Oxigeno\Extranet\PacienteBundle\Entity\Terapia',
        ));
    }
}
