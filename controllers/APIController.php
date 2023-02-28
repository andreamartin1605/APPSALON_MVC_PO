<?php

namespace Controllers;

use Model\Cita;
use Model\Servicio;
use Model\CitaServicio;

class APIController {
    public static function index() {
        $servicios = Servicio::all(); // Tomar todos los servicios del modelo
        echo json_encode($servicios); // json_encode: Convertir un arreglo a json 
    }

    public static function guardar() {
        
        // Almacena la cita y devuelve el ID
        $cita = new Cita($_POST); // Crear objeto de cita
        $resultado = $cita->guardar(); // Insertar en la BD
        
        $id = $resultado['id'];

        // Almacena la Cita y el Servicio
        // Almacena los servicios con el ID de la cita
        $idServicios = explode(",", $_POST['servicios']); // explode: Separarlos por comas

        foreach ($idServicios as $idServicio) { // foreach: Guardando cada uno de los servicios con la referencia de la cita
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar(); // Insertar en la BD 
        }
    
        echo json_encode(['resultado' => $resultado]);
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id']; // Leer ID
            $cita = Cita::find($id); // Encontrar ID
            $cita->eliminar(); // Eliminar ID
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}

