<?php
require '../vendor/autoload.php'; // Cargar librerías de Composer
require '../Controlador/conexion.php'; // Conexión a la BD

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Obtener la fecha de hoy (mes y día)
$fecha_hoy = date("m-d");

// Consulta para obtener al cumpleañero
$sql = "SELECT namee, email FROM user WHERE DATE_FORMAT(cumpleanios, '%m-%d') = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $fecha_hoy);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $nombre = $row['namee'];
    $email = $row['email'];

    // Crear instancia de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Verificar que la variable no está vacía
        if (empty($_ENV['SMTP_USER'])) {
            throw new Exception("Error: La dirección de correo del remitente está vacía.");
        }

        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USER'];
        $mail->Password = $_ENV['SMTP_PASS'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;


        // Configuración del correo
        $mail->setFrom($_ENV['SMTP_USER'], 'Equipo CTA');
        $mail->addAddress($email, $nombre);
        $mail->isHTML(true);
        $mail->Subject = 'Happy Birthday, ' . htmlspecialchars($nombre);

        // Contenido del correo
        $mail->Body = file_get_contents('../Vista/index.php'); // Cargar el HTML de la felicitación

        // Enviar correo
        $mail->send();
        echo "Correo enviado a $nombre ($email)";
    } catch (Exception $e) {
        echo "Error al enviar el correo: " . $mail->ErrorInfo;
    }
} else {
    echo "Hoy no hay cumpleañero.";
}

mysqli_close($conn);
?>
