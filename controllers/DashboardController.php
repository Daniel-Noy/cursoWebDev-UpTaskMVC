<?php 
namespace Controllers;

use Model\Proyecto;
use MVC\Router;

class DashboardController {
    public static function index(Router $router)
    {
        session_start();
        isAuth();


        $router->render("/dashboard/index", [
            "titulo" => "Proyectos"
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
                    header("Location: /proyecto?id=" . $proyecto->url);
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

        $router->render("/dashboard/perfil", [
            "titulo" => "Perfil"
        ]);
    }
}
