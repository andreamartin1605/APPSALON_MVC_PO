<?php

namespace Controllers;

use MVC\Router;
use Model\Servicio;

class ServicioController {
    public static function index(Router $router) {

        isAdmin(); // Proteger las Rutas

        $servicios = Servicio::all(); //all: Nos trae todos los servicios

        $router->render('servicios/index', [ 
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios
        ]);
    }

    public static function crear(Router $router) { // Mostrar Formulario
        //session_start();
        isAdmin();
        $servicio = new Servicio; // Instancia vacia
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') { // Lee lo que el usuario escribe en el formulario 
            $servicio->sincronizar($_POST); // Objeto en memoria los sincroniza con los datos del POST

            $alertas = $servicio->validar(); // Retornar alertas

            if(empty($alertas)) { // Si alertas esta vacio
                $servicio->guardar(); // Almacenarlo en la BD
                header('Location: /servicios');
            }
        }

        $router->render('servicios/crear', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function actualizar(Router $router) {
        isAdmin();
        if(!is_numeric($_GET['id'])) return;

        $servicio = Servicio::find($_GET['id']); // Trae el servicio que se va a actualizar
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio-> sincronizar($_POST);

            $alertas = $servicio->validar();

            if(empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        $router->render('servicios/actualizar', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function eliminar() {
        isAdmin();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $servicio = Servicio::find($id); // Buscar el servicio a eliminar
            $servicio->eliminar(); // Eliminar servicio
            header('Location: /servicios'); // Redireccionar
        }
    }
}