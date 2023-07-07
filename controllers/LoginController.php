<?php
namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();

            if( empty($alertas) ) {
                $usuario = Usuario::where("email", $auth->email);

                if( !$usuario ){
                    Usuario::setAlerta("error", "El usuario no existe");
                } else {
                    $pass = $usuario->comprobarLogin($auth->password);

                    if( $pass ){
                        $_SESSION["id"] = $usuario->id;
                        $_SESSION["nombre"] = $usuario->nombre;
                        $_SESSION["email"] = $usuario->email;
                        $_SESSION["login"] = true;

                        header("Location: /proyectos");
                    }
                }
            }
        }

        $router->render("auth/iniciar-sesion", [
            "titulo" => "Iniciar Sesion",
            "alertas" => Usuario::getAlertas(),
            "correo" => $auth->email ?? ''
        ]);
    }


    public static function logout(Router $router) {
        $_SESSION = [];
        header("Location: /");
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

                        header("Location: /cuenta/mensaje?tipo=creada");
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
        $mensajes = [
            "creada" => "Cuenta creada correctamente",
            "correo" => "Correo enviado",
            "pass" => "Contraseña reestablecida correctamente"
        ];

        $mensaje = $mensajes[$_GET["tipo"]] ?? '';


        $router->render("/auth/mensaje", [
            "titulo" => "OK",
            "mensaje" => $mensaje
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
                    $res = $usuario->guardar();
                    $mail = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $mail->enviarRecuperacionPass();

                    if( $res ) header("Location: /cuenta/mensaje?tipo=correo");
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

                if( $res ) header("Location: /cuenta/mensaje?tipo=pass");
            }
        }

        $router->render("auth/reestablecer", [
            "titulo" => "Reestablecer contraseña",
            "alertas" => Usuario::getAlertas(),
            "usuario" => $usuario
        ]);
    }
}