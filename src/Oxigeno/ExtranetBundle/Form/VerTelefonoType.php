<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Oxigeno\ExtranetBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * Description of VerTelefono
 *
 * @author francisco
 */
class VerTelefonoType extends TelefonoType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('numero', null, array(
                    'disabled' => true,
                ))
            ;
    }
    
}
