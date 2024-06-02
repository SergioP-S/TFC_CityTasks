<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require '..\vendor\autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $causes = [
        "Timo o Estafa",
        "Contenido Explícito",
        "Publicación Duplicada",
        "Publicidad o Spam",
        "Servicio Prohibido",
        "La imagen no coincide"
    ];

    // Obtener la causa seleccionada
    $causeIndex = $_POST['cause'];
    $message = $_POST['message'];
    
    if ($causeIndex !== "nulo") {
        $causeMessage = $causes[$causeIndex];
        
        // Dirección de correo electrónico a la que se enviará el reporte
        $to = "sergiotesting1234@gmail.com";
        $subject = "Reporte de Publicación";
        $body = "Hola, su publicación ha sido reportada.\n\nMotivo: $causeMessage\n\nMensaje adicional: $message";

        // Configurar PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Configuraciones del servidor
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io'; // Especifica el servidor SMTP de tu proveedor
            $mail->SMTPAuth = true;
            $mail->Username = 'e657f42214e679'; // Tu correo de envío
            $mail->Password = '4e4c985a2d39fe'; // Tu contraseña de correo
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587; // Puerto TCP para conexión, comúnmente 587 para TLS

            // Destinatarios
            $mail->setFrom('sergiotesting1234@gmail.com', 'Reporte de Publicación');
            $mail->addAddress($to); // Agregar destinatario

            // Contenido del correo
            $mail->isHTML(false); // Establecer el formato de correo a texto plano
            $mail->Subject = $subject;
            $mail->Body    = $body;

            // Enviar el correo
            $mail->send();
            echo "Reporte enviado con éxito.";
        } catch (Exception $e) {
            echo "Hubo un error al enviar el reporte: {$mail->ErrorInfo}";
        }
    } else {
        echo "Por favor, seleccione un motivo válido.";
    }
}
?>
