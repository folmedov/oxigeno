<?php

namespace Oxigeno\Extranet\SeguridadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\DBAL\DBALException;

use Oxigeno\Extranet\SeguridadBundle\Entity\ResetPassword;
use Oxigeno\Extranet\SeguridadBundle\Form\RecuperarPasswordType;
use Oxigeno\Extranet\PacienteBundle\Entity\Util;

class SeguridadController extends Controller {

    public function indexAction($name) {
        return $this->render('SeguridadBundle:Login:index.html.twig', array('name' => $name));
    }

    public function loginAction() {
        $peticion = $this->getRequest();

        $sesion = $peticion->getSession();

        $error = $peticion->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR, $sesion->get(SecurityContext::AUTHENTICATION_ERROR
        ));

        return $this->render('SeguridadBundle:Login:iniciar-sesion.html.twig', array(
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
            
            // obtengo el usuario propietario del correo
            $usuario = $em->getRepository('SeguridadBundle:Usuario')->findOneByCorreo($email_destino);
            
            if (!$usuario) {
                $msg = Util::MNS_LOGIN_RESET_PASS_CORREO_INVALIDO;
                return $this->render('SeguridadBundle:Login:solicitar-restablecer-password.html.twig', array(
                            'msg' => $msg,
                ));
            }
            
            if (!$usuario->esValidoSolicitarRestablecerPassword()) {
                $msg = Util::MNS_LOGIN_RESET_PASS_TOKEN_INVALIDO;
                return $this->render('SeguridadBundle:Login:solicitar-restablecer-password.html.twig', array(
                            'msg' => $msg,
                ));
            }
            
            $resetPassword = new ResetPassword();
            $resetPassword->setUsuario($usuario);
            
            $token = $resetPassword->getToken();

            $url = $this->generateUrl(
                    'seguridad_restablecer_password', 
                    array('key' => base64_encode($token->getKey())), 
                    true
            );

            $mensaje = \Swift_Message::newInstance()
                    ->setSubject('Restablecer contraseña en oxigeno')
                    ->setFrom('no-reply@oxigeno.dev')
                    ->setTo($email_destino)
                    ->setBody(
                            $this->renderView(
                                    'SeguridadBundle:Plantillas:email-restablecer-password.html.twig', 
                                    array(
                                        'usuario' => $usuario->getNombre(),
                                        'tiempo_validez' => $token->getTiempoValidez(),
                                        'url' => $url,
                                        )), 
                            'text/html')
                ;

            try {
                $em->persist($resetPassword);
                $em->flush();
                $this->get('mailer')->send($mensaje);
                $msg = Util::MNS_LOGIN_RESET_PASS_CORREO_ENVIADO;
            } catch (DBALException $exc) {
                $msg = 'Ya se ha solicitado restablecer su contraseña!';
            }
        }
        
        return $this->render('SeguridadBundle:Login:solicitar-restablecer-password.html.twig', array(
                    'msg' => $msg,
        ));
    }

    function restablecerPasswordAction() {
        $em = $this->getDoctrine()->getManager();
        $peticion = $this->getRequest();
        
        $msg = null;

        $token = $em->getRepository('SeguridadBundle:Token')
                        ->findOneByTokenCodificado($peticion->get('key'));

        if (!$token) {
            $msg = 'Error 404! ';
            return $this->render('SeguridadBundle:Login:restablecer-password.html.twig', array(
                        'key' => $peticion->get('key'),
                        'formulario' => isset($formulario) ? $formulario->createView() : null,
                        'msg' => $msg,
            ));
        }

        if (!$token->isValid()) {
            $msg = Util::MNS_LOGIN_RESET_PASS_TOKEN_CADUCADO;
            return $this->render('SeguridadBundle:Login:restablecer-password.html.twig', array(
                        'key' => $peticion->get('key'),
                        'formulario' => isset($formulario) ? $formulario->createView() : null,
                        'msg' => $msg,
            ));
        }

        $usuario = $em->getRepository('SeguridadBundle:Usuario')
                ->findOneByToken($token->getKey());
        
        $formulario = $this->createForm(new RecuperarPasswordType(), $usuario);

        if ($peticion->getMethod() == 'POST') {
            $formulario->bind($peticion);
            print_r($formulario->getErrors());

            if ($formulario->isValid()) {
                // setear la nueva contraseña y persistir los cambios!
                return $this->redirect($this->generateUrl('seguridad_login'));
            }
        }

        return $this->render('SeguridadBundle:Login:restablecer-password.html.twig', array(
                    'key' => $peticion->get('key'),
                    'formulario' => $formulario ? $formulario->createView() : null,
                    'msg' => $msg,
        ));
    }

}
