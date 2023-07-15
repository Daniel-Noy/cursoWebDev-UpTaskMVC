<?php
namespace Controllers;

use Model\Proyecto;
use Model\Tarea;

class TareaController {
    public static function index() {
        session_start();

        $proyectoId = $_GET['id'];
        if (!$proyectoId) header('Location: /dashboard');

        $proyecto = Proyecto::where("url", $proyectoId);

        if (!$proyecto || $proyecto->usuarioId !== $_SESSION["id"]) {
            header("Location: /404");
        }

        $tareas = Tarea::belongsTo('proyectoId', $proyecto->id);
        echo json_encode(['tareas' => $tareas]);
    } 

    public static function crearTarea() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            session_start();
            $proyectoId = $_POST["proyectoId"];
            
            $proyecto = Proyecto::where('url', $proyectoId);
            if (!$proyecto || $proyecto->usuarioId !==$_SESSION["id"]) {
                $res = [
                    "tipo" => "error",
                    "mensaje" => "Hubo un Error al agregar la tarea",
                ];

                echo json_encode($res);
                return;
            }

            $tarea = new Tarea([
                "nombre" => $_POST["nombre"],
                "proyectoId" => $proyecto->id
            ]);
            $res = $tarea->guardar();

            if ($res) {
                $res = [
                    "tipo" => "correcto",
                    "mensaje" => "Tarea creada correctamente",
                    "id" => $res["id"],
                    "proyectoId" => $proyecto->id,
                ];

            } else {
                $res = [
                    "tipo" => "error",
                    "mensaje" => "Hubo un Error al agregar la tarea"
                ];
            }

            echo json_encode($res);
        }
    }

    public static function actualizarTarea() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            session_start();
            $proyecto = Proyecto::where('url', $_POST["proyectoId"]);

            if (!$proyecto || $proyecto->usuarioId !==$_SESSION["id"]) {
                $res = [
                    "tipo" => "error",
                    "mensaje" => "Hubo un Error al actualizar el estado",
                ];

                echo json_encode($res);
                return;
            }

            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;
            $res = $tarea->guardar();

            if ($res) {
                $res = [
                    "tipo" => "correcto",
                    "mensaje" => "Estado de la tarea Actualizado",
                    "id" => $tarea->id,
                    "proyectoId" => $tarea->proyectoId
                ];
            }

            echo json_encode($res);
        }
    } 

    public static function eliminarTarea() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            
        }
    } 
}