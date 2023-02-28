<?php

namespace Model;

class Usuario extends ActiveRecord {
    // Base de Datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin',
    'confirmado', 'token']; //Iterar sobre los registros y los inserta en el objeto que esta en memoria.

    public $id; //Atributos
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    // Constructor
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;    
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';

    }   

    // Mensajes de validacón para la creación de una cuenta
    public function validarNuevaCuenta() {
        if(!$this->nombre) {
            self::$alertas['error'] [] = 'El Nombre es Obligatorio';
        }

        if(!$this->apellido) {
            self::$alertas['error'] [] = 'El Apellido es Obligatorio';
        }

        if(!$this->email) {
            self::$alertas['error'] [] = 'El Email es Obligatorio';
        }

        if(!$this->password) {
            self::$alertas['error'] [] = 'El Password es Obligatorio';
        }

        if(strlen($this->password) < 6) { // strlen: Longitud de un string - Contraseña 6 caracteres
            self::$alertas['error'] [] = 'El password debe contener al menos 6 caracteres';
        }

        return self::$alertas;
    }

    public function validarLogin() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es Obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password es Obligatorio';
        }

        return self::$alertas; 
    }

    public function validarEmail() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es Obligatorio';
        }
        return self::$alertas;
    }

    public function validarPassword() {
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password es Obligatorio';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El Password debe tener al menos 6 caracteres';
        }
        return self::$alertas;
    }

    // Revisa si el usuario ya existe-> con correo
    public function existeUsuario() {
        // Leer datos en memoria
        $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        
        $resultado = self::$db->query($query); // $db: Base de Datos - Realiza consulta
        
        if($resultado->num_rows) { // Usuario registrado
            self::$alertas['error'][] = 'El Usuario ya esta registrado'; // Agregar a las alertas
        }

        return $resultado; // Retornar resultado
    }

    public  function hashPassword() { // Metodo para hashear Password
        $this->password = password_hash($this->password, PASSWORD_BCRYPT); 
    }

    public function crearToken() { // Registro por email basado en tokens 
        $this->token = uniqid(); // uniqid: Generar un id unico
    }

    public function comprobarPasswordAndVerificado($password) {
        $resultado = password_verify($password, $this->password); // Verificar password este correcto

        if(!$resultado || !$this->confirmado) {
            self::$alertas['error'][] = 'Password Incorrecto o tu cuenta no ha sido confirmada';
        } else {
            return true;
        }
    }
}
