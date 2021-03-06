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
 * Description of PersonaType
 *
 * @author francisco
 */
class PersonaType extends AbstractType {

    public function getName() {
        return 'oxigeno_extranetpacientebundle_personatype';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('nombre')
                ->add('apellido')
                ->add('rut')
                ->add('email')
                ->add('fecha_nacimiento', 'birthday')
                ->add('direccion', new DireccionType())
                ->add('telefonos', 'collection', array(
                    'type' => new TelefonoType()
                ))
                ->add('fotografia', new ArchivoType(), array(
                    'required' => false
                ))
            ;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Oxigeno\Extranet\PacienteBundle\Entity\Persona', 
        ));
    }

}
