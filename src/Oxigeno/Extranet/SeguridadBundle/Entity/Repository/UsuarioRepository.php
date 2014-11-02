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
 * Description of UsuarioRepository
 *
 * @author francisco
 */
class UsuarioRepository extends EntityRepository {
    
    public function findOneByCorreo($correo) {
        $em = $this->getEntityManager();
        
        $dql =    'SELECT   u '
                . 'FROM     SeguridadBundle:Usuario u '
                . 'WHERE    u.email = :correo'
                ;
        
        $consulta = $em->createQuery($dql)->setParameters(array(
            'correo' => $correo,
        ));
        
        try {
            return $consulta->getSingleResult();
        } catch (NoResultException $ex) {
            return null;
        }
        
    }
    
    public function findOneByToken($token) {
        $em = $this->getEntityManager();
        
        $dql =    'SELECT   u '
                . 'FROM     SeguridadBundle:Token t '
                . 'JOIN     SeguridadBundle:ResetPassword rp WITH rp.token = t.id '
                . 'JOIN     SeguridadBundle:Usuario u WITH u.id = rp.usuario '
                . 'WHERE    t.token = :token'
                ;
        
        $consulta = $em->createQuery($dql)->setParameters(array(
            'token' => $token
        ));
        
        try {
            return $consulta->getSingleResult();
        } catch (NoResultException $ex) {
            return null;
        }
        
    }
}
