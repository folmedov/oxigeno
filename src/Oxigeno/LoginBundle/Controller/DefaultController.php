<?php

namespace Oxigeno\LoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\DBAL\DBALException;

use Oxigeno\LoginBundle\Entity\ResetPassword;
use Oxigeno\LoginBundle\Entity\Token;
use Oxigeno\LoginBundle\Form\UsuarioType;

class DefaultController extends Controller {

    public function loginAction() {
        $peticion = $this->getRequest();
        
        $sesion = $peticion->getSession();
        
        $error = $peticion->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR, 
                $sesion->get(SecurityContext::AUTHENTICATION_ERROR
            ));
        
        return $this->render('LoginBundle:Default:iniciar-sesion.html.twig', array(
            'last_username' => $sesion->get(SecurityContext::LAST_USERNAME),
            'error' => $error
        ));
    }
    
    public function solicitarRestablecerPasswordAction() {
        $msg = null;
        $peticion = $this->getRequest();
        
        if ($peticion->getMethod() == 'POST') {
            $email_destino = $peticion->get('email');
            
            $em = $this->getDoctrine()->getManager();
            $usuario = $em->getRepository('LoginBundle:Usuario')->findOneByCorreo($email_destino);
            if ($usuario) {
                $token = new Token();
                $resetPassword = new ResetPassword();
                $resetPassword->setUsuario($usuario);
                $resetPassword->setToken($token);
                
                $url = $this->generateUrl(
                        'login_restablecer_password', 
                        array('key' => base64_encode($token->getKey())),
                        true
                    );
                
                $tiempo_validez = $token->getFechaCreacion()->diff($token->getFechaValidez());
                $tiempo_validez = $tiempo_validez->format('%h hora(s)');
                
                $mensaje = \Swift_Message::newInstance()
                        ->setSubject('Restablecer contraseña en oxigeno')
                        ->setFrom('no-reply@oxigeno.dev')
                        ->setTo($email_destino)
                        ->setBody(
                                $this->renderView('LoginBundle:Plantillas:email-restablecer-password.html.twig', 
                                        array(
                                            'usuario' => $usuario->getNombre(), 
                                            'tiempo_validez' => $tiempo_validez,
                                            'url' => $url,
                                            )
                                    ),
                                'text/html'
                            )
                    ;
                
                try {
                    $em->persist($resetPassword);
                    $em->flush();
                    $this->get('mailer')->send($mensaje);
                    $msg = 'Se envio un correo a su email!';
                } catch (DBALException $exc) {
                    $msg = 'Ya se ha solicitado restablecer su contraseña!';
                }
            } else {
                $msg = 'El correo no esta registrado!';
            }
        }
        return $this->render('LoginBundle:Default:solicitar-restablecer-password.html.twig', array(
            'msg' => $msg,
        ));
    }
            
    function restablecerPasswordAction() {
        $em = $this->getDoctrine()->getManager();
        $peticion = $this->getRequest();
        
        $usuario = null;
        $formulario = null;
        
        $token = $em->getRepository('LoginBundle:Token')->findOneByTokenCodificado($peticion->get('key'));
        
        $msg = 'El tiempo de validez para cambiar su contraseña ha caducado '.$token->getFechaValidez()->format('d-m-Y H:i:s').'.';
        
        if ($token && $token->isValido()) {
            $msg = null;
            $usuario = $em->getRepository('LoginBundle:Usuario')
                    ->findOneByToken($token->getKey());
            
            $formulario = $this->createForm(new UsuarioType(), $usuario);
            
            if ($peticion->getMethod() == 'POST') {
                $formulario->bind($peticion);
                print_r($formulario->getErrors());
                
                if ($formulario->isValid()) {
                    // setear la nueva contraseña y persistir los cambios!
                    return $this->redirect($this->generateUrl('login_login'));
                }
                
            }
        }
        
        return $this->render('LoginBundle:Default:restablecer-password.html.twig', array(
                        'key' => $peticion->get('key'),
                        'formulario' => $formulario ? $formulario->createView() : null ,
                        'msg' => $msg,
            ));
        
    }

}
