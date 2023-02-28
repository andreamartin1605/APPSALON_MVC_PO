<?php 

require __DIR__ . '/../vendor/autoload.php'; // Carga automaticamente las dependencias de composer
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__); // Llamar dependencia vlucas - phpdotenv
$dotenv->safeLoad(); // Archivo no existe no marca error

require 'funciones.php';
require 'database.php';


// Conectarnos a la base de datos
use Model\ActiveRecord;
ActiveRecord::setDB($db);