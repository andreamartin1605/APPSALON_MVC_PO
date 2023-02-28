<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function esUltimo(string $actual, string $proximo): bool {
    if($actual !== $proximo) {
        return true;
    }
        return false;
}

// Función que revisa que el usuario este autenticado
function isAuth() : void { // void: No va a retornar nada
    if(!isset($_SESSION['login'])) { // Si no esta definida la variable login como true
        header('Location: /'); // Redirecciona al usuario
    }
}

function isAdmin() : void {
    if(!isset($_SESSION['admin'])) { // Si no es un admin
        header('Location: /'); // Redireccionar a Iniciar Sesión
    }
}

