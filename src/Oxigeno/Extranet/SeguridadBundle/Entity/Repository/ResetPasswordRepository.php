<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Oxigeno\Extranet\SeguridadBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of ResetPasswordRepository
 *
 * @author francisco
 */
class ResetPasswordRepository extends EntityRepository {
    
    public function findByUsuario($usuario_id) {
        $em = $this->getEntityManager();
        
        $dql =    'SELECT   rp '
                . 'FROM     SeguridadBundle:ResetPassword rp '
                . 'JOIN     rp.usuario u '
                . 'WHERE    u.id = :usuario_id'
            ;
        
        $consulta = $em->createQuery($dql)->setParameters(array(
            'usuario_id' => $usuario_id,
        ));
        
        return $consulta->getResult();
    }
}
