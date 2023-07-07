<?php
namespace Model;

class Usuario extends ActiveRecord {
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ["id", "nombre", "email", "password", "token", "confirmado"];

    public $id;
    public $nombre;
    public $email;
    public $password;
    public $passwordCheck;
    public $token;
    public $confirmado;

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? '';
        $this->email = $args["email"] ?? '';
        $this->password = $args["password"] ?? '';
        $this->passwordCheck = $args["passwordCheck"] ?? '';
        $this->token = $args["token"] ?? '';
        $this->confirmado = $args["confirmado"] ?? 0;
    }

    public function validarCuentaNueva()
    {
        if( !$this->nombre ) $this->setAlerta("error", "El nombre es obligatorio");
        if( !$this->email ) $this->setAlerta("error", "El email es obligatorio");

        if( !$this->password ) $this->setAlerta("error", "Debes ingresar una contraseña");
        if( strlen($this->password) < 6 ) $this->setAlerta("error", "La contraseña debe contener al menos 6 caracteres");
        if( $this->password !== $this->passwordCheck ) $this->setAlerta("error", "Las contraseñas no coinciden");

        return $this->getAlertas();
    }

    function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
    
    function crearToken() {
        $this->token = uniqid();
    }
}