<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Oxigeno\ExtranetBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * Description of VerPersonaType
 *
 * @author francisco
 */
class VerPersonaType extends PersonaType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('nombre', null, array('disabled' => true))
                ->add('apellido', null, array('disabled' => true))
                ->add('rut', null, array('disabled' => true))
                ->add('email', null, array('disabled' => true))
                ->add('fecha_nacimiento', 'birthday', array('disabled' => true))
                ->add('direccion', new VerDireccionType())
                ->add('telefonos', 'collection', array(
                    'type' => new VerTelefonoType()
                ))
            ;
    }
}
