<?php 
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    protected  $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    protected function getConfig(string $subject) {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV["EMAIL_HOST"];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV["EMAIL_PORT"];
        $mail->Username = $_ENV["EMAIL_USER"];
        $mail->Password = $_ENV["EMAIL_PASS"];
        $mail->CharSet = 'UTF-8';

        $mail->setFrom("cuentas@uptask.com");
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = $subject;

        return $mail;
    }

    public function enviarConfirmación() {
        $mail = $this->getConfig("Confirma tu cuenta | Up task");

        $contenido = "<html>";
        $contenido .= "<p><strong> Hola " . $this->nombre . "</strong></p>";
        $contenido .= "<p>Para confirmar tu cuenta entra en el sig. enlace</p>";
        $contenido .= "<p>Presiona aqui: <a href='" . $_ENV["APP_URL"] . "/cuenta/confirmar?token={$this->token}'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tu no solicitaste esto, puedes ignorar este email</p>";
        $contenido .= "</html>";

        $mail->isHTML();
        $mail->Body =  $contenido;
        $mail->send();
    }
}