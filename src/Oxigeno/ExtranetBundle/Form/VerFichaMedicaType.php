<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Oxigeno\ExtranetBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * Description of VerFichaMedica
 *
 * @author francisco
 */
class VerFichaMedicaType extends FichaMedicaType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('diagnostico', null, array('disabled' => true))
            ;
    }
    
}
