<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion() {
        
        // Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '66ecf5cb73f266';
        $mail->Password = '0cd8e204c8e1ca';

        $mail->setFrom('cuentas@appsalon.com'); // Quien lo envia
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com'); // A quien lo envia
        $mail->Subject = 'Confirma tu cuenta'; // Titulo correo

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';
        
        // Cuerpo del Email
        $contenido = '<html>';
        $contenido .= "<p><strong>Hola " . $this->email . "</strong> Has creado tu cuenta
        en App Salón, solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aqui: <a href='http://localhost:3000/confirmar-cuenta?token="
        . $this->token . "'>Confirmar Cuenta</a> </p>";
        $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>";
        $contenido .= '</html>';
        // Agregar al body
        $mail->Body = $contenido;

        // Enviar el mail
        $mail->send();  
    }

    public function enviarInstrucciones() {
        // Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '66ecf5cb73f266';
        $mail->Password = '0cd8e204c8e1ca';

        $mail->setFrom('cuentas@appsalon.com'); // Quien lo envia
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com'); // A quien lo envia
        $mail->Subject = 'Restablece tu password'; // Titulo correo

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';
        
        // Cuerpo del Email
        $contenido = '<html>';
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has solicitado 
        reestablecer tu password, sigue el siguiente enlace para hacelo. </p>";
        $contenido .= "<p>Presiona aqui: <a href='http://localhost:3000/recuperar?token="
        . $this->token . "'>Reestablecer Password</a> </p>";
        $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>";
        $contenido .= '</html>';
        // Agregar al body
        $mail->Body = $contenido;

        // Enviar el mail
        $mail->send();
    }
}