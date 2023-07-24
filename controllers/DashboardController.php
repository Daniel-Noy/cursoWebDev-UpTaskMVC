<?php 
namespace Controllers;

use Model\Proyecto;
use Model\Usuario;
use MVC\Router;

class DashboardController {
    public static function index(Router $router)
    {
        session_start();
        isAuth();
        $id = $_SESSION["id"];

        $proyectos = Proyecto::belongsTo("usuarioId", $id);

        $router->render("/dashboard/index", [
            "titulo" => "Proyectos",
            "proyectos" => $proyectos
        ]);
    }

    public static function proyecto(Router $router)
    {
        session_start();
        isAuth();
        
        $token = $_GET["id"];
        if (!$token) {
            header("Location: /dashboard");
        }

        $proyecto = Proyecto::where("url", $token);
        if ($proyecto->usuarioId !== $_SESSION["id"]) {
            header("Location: /dashboard");
        }

        $titulo = $proyecto->proyecto;

        $router->render("/dashboard/proyecto", [
            "titulo" => $titulo
        ]);
    }

    public static function crearProyecto(Router $router)
    {
        session_start();
        isAuth();

        if ($_SERVER["REQUEST_METHOD"] === "POST")
        {
            $proyecto = new Proyecto($_POST);
            $alertas = $proyecto->validarProyecto();

            if (empty($alertas)) {
                $proyecto->generarUrl();
                $proyecto->usuarioId = $_SESSION["id"];
                $res = $proyecto->guardar();

                if ($res) {
                    header("Location: /dashboard/proyecto?id=" . $proyecto->url);
                } else {
                    Proyecto::setAlerta("error", "Hubo un error al crear el proyecto");
                }
            }
        }

        $router->render("/dashboard/crear-proyecto", [
            "titulo" => "Crear Proyecto",
            "alertas" => Proyecto::getAlertas()
        ]);
    }

    public static function perfil(Router $router)
    {
        session_start();
        isAuth();

        $usuario = Usuario::find($_SESSION["id"]);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarPerfil();

            if (empty($alertas)) {
                $existeUsuario = Usuario::where("email", $usuario->email);
                if ($existeUsuario && $existeUsuario->id !== $usuario->id) {
                    Usuario::setAlerta("error", "Este correo ya esta registrado");
                } else {
                    $res = $usuario->guardar();
                    if ($res) {
                        $_SESSION["nombre"] = $usuario->nombre;
                        $_SESSION["email"] = $usuario->email;
                        Usuario::setAlerta("correcto", "Se han actualizado los datos correctamente");
                    }
                }

            }
        }

        $router->render("/dashboard/perfil", [
            "titulo" => "Perfil",
            "alertas" => Usuario::getAlertas(),
        ]);
    }

    public static function cambiarPassword(Router $router)
    {
        session_start();
        isAuth();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $usuario = Usuario::find($_SESSION["id"]);
            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarNuevoPassword();
            if (empty($alertas)) {
                $pass = $usuario->comprobarPassword();

                if ($pass) {
                    $usuario->password = $usuario->nuevoPassword;
                    $usuario->hashPassword();
                    $res = $usuario->guardar();

                    if ($res) {
                        Usuario::setAlerta("correcto", "Contraseña cambiada correctamente");
                    }
                } else {
                    Usuario::setAlerta("error", "La contraseña actual no coincide");
                }
            }

        }

        $router->render('dashboard/cambiar-password', [
            "titulo" => "Cambiar contraseña",
            "alertas" => Usuario::getAlertas()
        ]);
    }
}
