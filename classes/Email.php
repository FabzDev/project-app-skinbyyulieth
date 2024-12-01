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
            $correo->Host = $_ENV['EMAIL_HOST'];
            $correo->SMTPAuth = true;
            $correo->Port = $_ENV['EMAIL_PORT'];
            $correo->Username = $_ENV['EMAIL_USER'];
            $correo->Password = $_ENV['EMAIL_PASS'];
            
            $correo->setFrom('notificaciones@skinbyyulieth.com');
            $correo->addAddress('fabioescobarardila@hotmail.com');
            $correo->Subject = 'Probando email skin by Yulieth';

            //Set HTML
            $correo->isHTML(TRUE);
            $correo->CharSet = 'UTF-8';

            $contenido = "<html>";
            $contenido .= "<p><strong>Hola ".$this->nombre."</strong>. Has creado tu cuenta en SkinByYulieth, para confirmar tu cuenta ingresa al siguiente enlace</p>";
            $contenido .= "<p>Presiona aqui: <a href='". $_ENV['APP_URL'] ."/confirmar-cuenta?token=".$this->token."'>Confirmar cuenta</a><p>";
            $contenido .= "<p?>Si tu no creaste esta por favor ignora este mensaje</p>";
            $contenido .= "</html>";
            
            $correo->Body = $contenido;

            //Enviar email
            $correo->send();
        }

        public function enviarInstrucciones(){
            $correo = new PHPMailer();
            $correo->isSMTP();
            $correo->Host = $_ENV['EMAIL_HOST'];
            $correo->SMTPAuth = true;
            $correo->Port = $_ENV['EMAIL_PORT'];
            $correo->Username = $_ENV['EMAIL_USER'];
            $correo->Password = $_ENV['EMAIL_PASS'];
            
            $correo->setFrom('notificaciones@skinbyyulieth.com');
            $correo->addAddress('fabioescobarardila@hotmail.com');
            $correo->Subject = 'Restablecer Password';

            //Set HTML
            $correo->isHTML(TRUE);
            $correo->CharSet = 'UTF-8';

            $contenido = "<html>";
            $contenido .= "<p>Hola <strong>".$this->nombre."</strong>. Para restablecer tu Password has click en el siguiente enlace:</p>";
            $contenido .= "<p><a href='". $_ENV['APP_URL'] ."/recuperar?token=".$this->token."'>Restablecer Password</a><p>";
            $contenido .= "<p?>Si tu no creaste esta por favor ignora este mensaje</p>";
            $contenido .= "</html>";
            
            $correo->Body = $contenido;

            //Enviar email
            $correo->send();
        }
    }