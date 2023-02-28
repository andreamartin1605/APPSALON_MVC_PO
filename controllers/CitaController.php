<?php

namespace Controllers;

use MVC\Router;

class CitaController {
    public static function index( Router $router) {

        session_start(); // Arrancar la sesion de nuevo

        isAuth(); // Comprobar si el usuario esta autenticado

        $router->render('cita/index', [ // Vista
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id'] 
        ]);

    }
}