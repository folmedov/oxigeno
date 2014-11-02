<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Oxigeno\Extranet\PacienteBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * Description of VerPacienteType
 *
 * @author francisco
 */
class VerPacienteType extends PacienteType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('fecha_ingreso', 'date', array(
                        'disabled' => true
                    ))
                ->add('persona', new VerPersonaType())
                ->add('ficha_medica', new VerFichaMedicaType())
            ;
    }
}
