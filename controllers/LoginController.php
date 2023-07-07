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
                        header('Location: /cuenta/mensaje');
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

    public static function mensaje(Router $router) {
        $router->render("/auth/mensaje", [
            "titulo" => "Cuenta Creada"
        ]);
    }
    
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

        
        $alertas = Usuario::getAlertas();
        $router->render("auth/confirmar-cuenta", [
            "titulo" => "Cuenta Confirmada",
            "alertas" => $alertas
        ]);
    }

    // Contraseñas
    public static function olvide(Router $router) {

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            
        }
        
        $alertas = Usuario::getAlertas();
        $router->render("/auth/olvide-password", [
            "titulo" => "Recuperar Contraseña",
            "alertas" => $alertas
        ]);
    }

    // Contraseñas
    public static function reestablecer(Router $router) {


        if($_SERVER["REQUEST_METHOD"] === "POST") {

        }

        $router->render("auth/reestablecer", [
            "titulo" => "Reestablecer contraseña"
        ]);
    }
}