<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Oxigeno\Extranet\SeguridadBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * Description of TokenRepository
 *
 * @author francisco
 */
class TokenRepository extends EntityRepository {
    
    public function findOneByTokenCodificado($token_codificado) {
        $em = $this->getEntityManager();
        
        $dql =    'SELECT   t '
                . 'FROM     SeguridadBundle:Token t '
                . 'WHERE    t.token = :token'
                ;
        
        $consulta = $em->createQuery($dql)->setParameters(array(
            'token' => base64_decode($token_codificado),
        ));
        
        try {
            return $consulta->getSingleResult();
        } catch (NoResultException $ex) {
            return null;
        }
        
        
    }
}
