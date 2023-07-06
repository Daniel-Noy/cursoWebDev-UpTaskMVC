<?php
namespace Controllers;

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


        if($_SERVER["REQUEST_METHOD"] === "POST") {

        }

        $router->render("auth/crear-cuenta", [
            "titulo" => "Crear cuenta"
        ]);
    }

    public static function mensaje(Router $router) {
        $router->render("/auth/mensaje", [
            "titulo" => "Cuenta Creada"
        ]);
    }

    public static function confirmar(Router $router) {
        $router->render("auth/confirmar-cuenta", [
            "titulo" => "Cuenta Confirmada"
        ]);
    }

    // Contraseñas
    public static function olvide(Router $router) {


        if($_SERVER["REQUEST_METHOD"] === "POST") {

        }

        $router->render("/auth/olvide-password", [
            "titulo" => "Recuperar Contraseña"
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