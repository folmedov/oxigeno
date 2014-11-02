<?php

namespace Oxigeno\Extranet\SeguridadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\DBAL\DBALException;

use Oxigeno\Extranet\SeguridadBundle\Entity\ResetPassword;
use Oxigeno\Extranet\SeguridadBundle\Entity\Token;
use Oxigeno\Extranet\SeguridadBundle\Form\RecuperarPasswordType;

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
                $msg = 'El correo ingresado no está registrado.';
                return $this->render('SeguridadBundle:Login:solicitar-restablecer-password.html.twig', array(
                            'msg' => $msg,
                ));
            }
            
            if (!$usuario->esValidoSolicitarRestablecerPassword()) {
                $msg = 'Ya se ha solicitado restablecer su contraseña en un periodo inferior a 1 hora.';
                return $this->render('SeguridadBundle:Login:solicitar-restablecer-password.html.twig', array(
                            'msg' => $msg,
                ));
            }
            
            $resetPassword = new ResetPassword();
            $resetPassword->setUsuario($usuario);

            $url = $this->generateUrl(
                    'seguridad_restablecer_password', 
                    array('key' => base64_encode($resetPassword->getToken()->getKey())), true
            );

            $tiempo_validez = $resetPassword->getToken()->getFechaCreacion()
                    ->diff($resetPassword->getToken()->getFechaValidez());
            $tiempo_validez = $tiempo_validez->format('%h hora(s)');

            $mensaje = \Swift_Message::newInstance()
                    ->setSubject('Restablecer contraseña en oxigeno')
                    ->setFrom('no-reply@oxigeno.dev')
                    ->setTo($email_destino)
                    ->setBody(
                    $this->renderView('SeguridadBundle:Plantillas:email-restablecer-password.html.twig', array(
                        'usuario' => $usuario->getNombre(),
                        'tiempo_validez' => $tiempo_validez,
                        'url' => $url,
                            )
                    ), 'text/html'
                    )
            ;

            try {
                $em->persist($resetPassword);
                $em->flush();
                $this->get('mailer')->send($mensaje);
                $msg = 'Se ha enviado un email a su correo electronico con '
                        . 'las instrucciones a seguir.';
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

        $usuario = null;
        $formulario = null;

        $token = $em->getRepository('SeguridadBundle:Token')->findOneByTokenCodificado($peticion->get('key'));

        $msg = 'El tiempo de validez para cambiar su contraseña ha caducado ' . $token->getFechaValidez()->format('d-m-Y H:i:s') . '.';

        if ($token && $token->isValid()) {
            $msg = null;
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
        }

        return $this->render('SeguridadBundle:Login:restablecer-password.html.twig', array(
                    'key' => $peticion->get('key'),
                    'formulario' => $formulario ? $formulario->createView() : null,
                    'msg' => $msg,
        ));
    }

}
