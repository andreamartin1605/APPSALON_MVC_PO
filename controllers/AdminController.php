<?php

namespace Controllers;

use MVC\Router;
use Model\AdminCita;

class AdminController {
    public static function index( Router $router ) {

        isAdmin();

        $fecha = $_GET['fecha'] ?? date('Y-m-d'); // date: Obtener fecha actual del servidor
        $fechas = explode('-', $fecha); // Separar por guion

        if( !checkdate( $fechas[1], $fechas[2], $fechas[0]) ) {
            header('Location: /404');
        }

        // Consultar la Base de Datos
        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasservicios ";
        $consulta .= " ON citasservicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasservicios.servicioId ";
        $consulta .= " WHERE fecha =  '${fecha}' ";

        $citas = AdminCita::SQL($consulta);

        $router->render('admin/index', [ // Vista
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha 
        ]);
    }
}