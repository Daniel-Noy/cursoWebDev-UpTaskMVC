<?php
namespace Controllers;

use Model\Proyecto;
use Model\Tarea;

class TareaController {
    public static function index() {
        

    } 

    public static function crearTarea() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            session_start();
            $proyectoId = $_POST["proyectoId"];
            
            $proyecto = Proyecto::where('url', $proyectoId);
            if (!$proyecto || $proyecto->usuarioId !==$_SESSION["id"]) {
                $res = [
                    "tipo" => "error",
                    "mensaje" => "Hubo un Error al agregar la tarea"
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
                    "mensaje" => "Tarea creada correctamente"
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
            
        }
    } 

    public static function eliminarTarea() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            
        }
    } 
}