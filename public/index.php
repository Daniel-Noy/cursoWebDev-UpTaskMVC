<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\LoginController;
use MVC\Router;
$router = new Router();

// Autenticación
$router->get("/", [LoginController::class, "login"]);
$router->post("/", [LoginController::class, "login"]);

$router->get("/cuenta/logout", [LoginController::class, "logout"]);

// Cuenta
$router->get("/cuenta/crear", [LoginController::class, "crear"]);
$router->post("/cuenta/crear", [LoginController::class, "crear"]);

$router->get("/cuenta/mensaje", [LoginController::class, "mensaje"]);

$router->get("/cuenta/confirmar", [LoginController::class, "confirmar"]);

// Contraseña
$router->get("/cuenta/contraseña/olvide", [LoginController::class, "olvide"]);
$router->post("/cuenta/contraseña/olvide", [LoginController::class, "olvide"]);

$router->get("/cuenta/contraseña/reestablecer", [LoginController::class, "reestablecer"]);
$router->post("/cuenta/contraseña/reestablecer", [LoginController::class, "reestablecer"]);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();