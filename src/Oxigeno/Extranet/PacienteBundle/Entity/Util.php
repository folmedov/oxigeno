<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Oxigeno\Extranet\PacienteBundle\Entity;

/**
 * Description of Util
 *
 * @author francisco
 */
abstract class Util {
    const MNS_PACIENTE_INGRESAR = 'Se registró correctamente el paciente en el sistema.';
    const MNS_PACIENTE_EDITAR = 'Se editó correctamente la información del paciente en el sistema.';
    
    static function generarContrasena($longitud) {
        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $cad = "";
        for ($i = 0; $i < $longitud; $i++) {
            $cad .= substr($str, rand(0, 62), 1);
        }
        return $cad;
    }
}
