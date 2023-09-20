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
    public $nuevoPassword;
    public $actualPassword;
    public $token;
    public $confirmado;

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? '';
        $this->email = $args["email"] ?? '';
        $this->password = $args["password"] ?? '';
        $this->passwordCheck = $args["passwordCheck"] ?? '';
        $this->nuevoPassword = $args["nuevoPassword"] ?? '';
        $this->actualPassword = $args["actualPassword"] ?? '';
        $this->token = $args["token"] ?? '';
        $this->confirmado = $args["confirmado"] ?? 1;
    }

    public function validarLogin() {
        $this->validarEmail();
        $this->validarContraseña();

        return self::getAlertas();
    }

    public function validarCuentaNueva() {
        if( !$this->nombre ) self::setAlerta("error", "El nombre es obligatorio");
        $this->validarEmail();
        $this->validarContraseña();
        if( $this->password !== $this->passwordCheck ) self::setAlerta("error", "Las contraseñas no coinciden");

        return self::getAlertas();
    }

    public function validarPerfil() {
        $this->validarEmail();

        if(!$this->nombre) {
            self::$alertas["error"][] = "El Nombre es Obligatorio";
        }

        return self::$alertas;
    }

    public function validarEmail() {
        if( !$this->email || !filter_var($this->email, FILTER_VALIDATE_EMAIL) ) {
            self::$alertas["error"][] = "Ingresa un email valido";
        }

        return self::$alertas;
    }

    public function validarContraseña() {
        if( !$this->password ){
            self::setAlerta("error", "Debes ingresar una contraseña");

        } else if( strlen($this->password) < 6 ) {
            self::setAlerta("error", "La contraseña debe contener al menos 6 caracteres");

        } 
        return self::getAlertas();
    }

    public function validarNuevoPassword() {
        if (!$this->actualPassword || !$this->nuevoPassword) {
            self::$alertas["error"][] = "Debes llenar los espacios";
        }

        if (strlen($this->nuevoPassword) <= 6) {
            self::$alertas["error"][] = "La contraseña debe ser de 6 caracteres como minimo";
        }

        return self::$alertas;
    }

    public function comprobarLogin(string $password) {
        $pass = password_verify($password, $this->password);

        if (!$pass) {
            self::$alertas["error"][] = "Contraseña incorrecta";
            return false;
        } 
        // else { //? Confirmacion desactivada por demo
        //     if(!$this->confirmado) {
        //         self::$alertas["error"][] = "Aún no se ha confirmado tu cuenta";

        //     } else return true;
        // }
        return true;
    }

    public function comprobarPassword() {
        $res = password_verify($this->actualPassword, $this->password);
        return $res;
    }

    function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
    
    function crearToken() {
        $this->token = uniqid();
    }
}