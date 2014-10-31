<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Oxigeno\LoginBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of TokenRepository
 *
 * @author francisco
 */
class TokenRepository extends EntityRepository {
    
    public function findOneByTokenCodificado($token_codificado) {
        $em = $this->getEntityManager();
        
        $dql =    'SELECT   t '
                . 'FROM     LoginBundle:Token t '
                . 'WHERE    t.token = :token'
                ;
        
        $consulta = $em->createQuery($dql)->setParameters(array(
            'token' => base64_decode($token_codificado),
        ));
        
        return $consulta->getSingleResult();
    }
}
