<?php 
    namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

    class Email {
        public $nombre;
        public $email;
        public $token;
        
        public function __construct($nombre, $email, $token){
            $this->nombre = $nombre;
            $this->email = $email;
            $this->token = $token;
        }

        public function enviarConfirmacion(){
            //crear objeto correo
            $correo = new PHPMailer();
            $correo->isSMTP();
            $correo->Host = 'sandbox.smtp.mailtrap.io';
            $correo->SMTPAuth = true;
            $correo->Port = 2525;
            $correo->Username = '0916c80e86e91c';
            $correo->Password = 'db47cdee41adcd';
            
            $correo->setFrom('notificaciones@skinbyyulieth.com');
            $correo->addAddress('fabioescobarardila@hotmail.com');
            $correo->Subject = 'Probando email skin by Yulieth';

            //Set HTML
            $correo->isHTML(TRUE);
            $correo->CharSet = 'UTF-8';

            $contenido = "<html>";
            $contenido .= "<p><strong>Hola ".$this->nombre."</strong>. Has creado tu cuenta en SkinByYulieth, para confirmar tu cuenta ingresa al siguiente enlace</p>";
            $contenido .= "<p>Presiona aqui: <a href='http://localhost:3000/confirmar-cuenta?token=".$this->token."'>Confirmar cuenta</a><p>";
            $contenido .= "<p?>Si tu no creaste esta por favor ignora este mensaje</p>";
            $contenido .= "</html>";
            
            $correo->Body = $contenido;

            //Enviar email
            $correo->send();
        }
    }