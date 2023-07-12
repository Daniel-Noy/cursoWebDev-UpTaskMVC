<?php
namespace Model;

class Proyecto extends ActiveRecord {
    protected static $tabla = 'proyectos';
    protected static $columnasDB = ["id", "proyecto", "url", "usuarioId"];

    public $id;
    public $proyecto;
    public $url;
    public $usuarioId;

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->proyecto = $args["proyecto"] ?? '';
        $this->url = $args["url"] ?? '';
        $this->usuarioId = $args["usuarioId"] ?? null;
        
    }

    public function validarProyecto()
    {
        if (!$this->proyecto) {
            self::$alertas["error"][] = "Tu proyecto debe tener un nombre";
            return self::$alertas;
        }
    }

    public function generarUrl()
    {
        $url = md5(uniqid());
        $this->url = $url;
    }
}
