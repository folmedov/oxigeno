<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Oxigeno\ExtranetBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Description of PacienteRepository
 *
 * @author francisco
 */
class PacienteRepository extends EntityRepository {
    
    public function findPacientes() {
        $em = $this->getEntityManager();
        
        $dql =    'SELECT   pa, pe, di, te '
                . 'FROM     ExtranetBundle:Paciente pa '
                . 'JOIN     pa.persona pe '
                . 'JOIN     pe.telefonos te '
                . 'JOIN     pe.direccion di'
                ;
        
        $consulta = $em->createQuery($dql);
        
        return $consulta->getResult();
    }
}
