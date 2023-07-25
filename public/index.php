<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\DashboardController;
use Controllers\LoginController;
use Controllers\TareaController;
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
$router->get("/cuenta/password/olvide", [LoginController::class, "olvide"]);
$router->post("/cuenta/password/olvide", [LoginController::class, "olvide"]);

$router->get("/cuenta/password/reestablecer", [LoginController::class, "reestablecer"]);
$router->post("/cuenta/password/reestablecer", [LoginController::class, "reestablecer"]);

// Dashboard
$router->get("/dashboard", [DashboardController::class, "index"]);
$router->post("/dashboard", [DashboardController::class, "index"]); // borrar al configurar git

$router->get("/dashboard/proyecto", [DashboardController::class, "proyecto"]);
$router->post("/dashboard/proyecto", [DashboardController::class, "proyecto"]);

$router->get("/dashboard/proyecto/crear", [DashboardController::class, "crearProyecto"]);
$router->post("/dashboard/proyecto/crear", [DashboardController::class, "crearProyecto"]);

$router->get("/perfil", [DashboardController::class, "perfil"]);
$router->post("/perfil", [DashboardController::class, "perfil"]);

$router->get("/perfil/password", [DashboardController::class, "cambiarPassword"]);
$router->post("/perfil/password", [DashboardController::class, "cambiarPassword"]);

// Tareas
$router->get('/api/tareas', [TareaController::class, "index"]);
$router->post('/api/tareas/crear', [TareaController::class, "crearTarea"]);
$router->post('/api/tareas/actualizar', [TareaController::class, "actualizarTarea"]);
$router->post('/api/tareas/eliminar', [TareaController::class, "eliminarTarea"]);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();