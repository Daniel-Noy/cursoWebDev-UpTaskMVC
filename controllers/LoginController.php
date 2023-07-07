<?php
namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {


        if($_SERVER["REQUEST_METHOD"] === "POST") {

        }

        $router->render("auth/iniciar-sesion", [
            "titulo" => "Iniciar Sesion"
        ]);
    }

    public static function logout(Router $router) {

    }

    public static function crear(Router $router) {
        $usuario = new Usuario;
        $alertas = $usuario->getAlertas();

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarCuentaNueva();
            $existeUsuario = Usuario::where("email", $usuario->email);

            
            if( empty($alertas) ) {
                if( $existeUsuario ) {
                    $usuario->setAlerta("error", "El email ya esta registrado");
                    $alertas = $usuario->getAlertas();
                } else {
                    $usuario->hashPassword();
                    $usuario->crearToken();
                    unset($usuario->passwordCheck);
                    $res = $usuario->guardar();
                    
                    if( $res ) {
                        $mail = new Email($usuario->email, $usuario->nombre, $usuario->token);
                        $mail->enviarConfirmación();

                        $router->render("auth/mensaje", [
                            "titulo" => "Cuenta creada",
                            "mensaje" => "La cuenta ha sido creada correctamente"
                        ]);
                    }
                }
            }


        }

        $router->render("auth/crear-cuenta", [
            "titulo" => "Crear cuenta",
            "usuario" => $usuario,
            "alertas" => $alertas
        ]);
    }

    // public static function cuentaCreada(Router $router) {
    //     $router->render("/auth/mensaje", [
    //         "titulo" => "Cuenta Creada",
    //         "mensaje" => "Tu cuenta fue creada correctamente"
    //     ]);
    // }
    
    public static function confirmar(Router $router) {
        $token = s($_GET["token"]);

        if( !$token ) header("Location: /");

        $usuario = Usuario::where("token", $token);
        
        if( $usuario ){
            $usuario->token = '';
            $usuario->confirmado = 1;
            $res = $usuario->guardar();
            
            if($res) {
                Usuario::setAlerta("correcto", "Cuenta confirmada");
            }
        } else Usuario::setAlerta("error", "Token Invalido");

        
        $router->render("auth/confirmar-cuenta", [
            "titulo" => "Cuenta Confirmada",
            "alertas" => Usuario::getAlertas()
        ]);
    }

    // Contraseñas
    public static function olvide(Router $router) {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();

            if( empty($alertas)) {
                $usuario = Usuario::where("email", $usuario->email);

                if( !$usuario ){
                    Usuario::setAlerta("error", "Este correo no esta asociado a ninguna cuenta");
                } else if ( !$usuario->confirmado ){
                    Usuario::setAlerta("error", "Aun no has confirmado tu cuenta");
                    
                } else if ( $usuario->token ) {
                    Usuario::setAlerta("info", "Ya hemos enviado un correo anteriormente, revisa tu bandeja");
                    
                } else {
                    $usuario->crearToken();
                    $usuario->guardar();
                    $mail = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $mail->enviarRecuperacionPass();

                    $router->render("auth/mensaje", [
                        "titulo" => "Correo enviado",
                        "mensaje" => "Hemos enviado un correo con las instrucciones para reestablecer tu contraseña"
                    ]);
                }
            }
        }
        
        $router->render("/auth/olvide-password", [
            "titulo" => "Recuperar Contraseña",
            "alertas" => Usuario::getAlertas()
        ]);
    }

    // Contraseñas
    public static function reestablecer(Router $router) {
        $token = s($_GET["token"]);
        
        if (!$token) header("Location: /");

        $usuario = Usuario::where("token", $token);
        if( !$usuario ) { Usuario::setAlerta("error", "Token invalido"); } 

        if( $_SERVER["REQUEST_METHOD"] === "POST" ) {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarContraseña();

            if( empty($alertas) ) {
                $usuario->hashPassword();
                $usuario->token = '';
                $res = $usuario->guardar();

                if($res){
                    $router->render("auth/mensaje", [
                        "titulo" => "Reestablecer contraseña",
                        "mensaje" => "Has reestablecido tu contraseña correctamente"
                    ]);
                }
            }
        }

        $router->render("auth/reestablecer", [
            "titulo" => "Reestablecer contraseña",
            "alertas" => Usuario::getAlertas(),
            "usuario" => $usuario
        ]);
    }
}