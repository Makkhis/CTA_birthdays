<?php
require '../vendor/autoload.php'; // Cargar librerías de Composer
require '../controller/conexion.php'; // Conexión a la BD

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Obtener la fecha de hoy (mes y día)
$fecha_hoy = date("m-d");

// Consulta para obtener al cumpleañero
$sql = "SELECT name, email FROM user WHERE DATE_FORMAT(birthday, '%m-%d') = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $fecha_hoy);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $nombre = $row['name'];
    $email = $row['email'];

    // Crear instancia de PHPMailer
    $mail = new PHPMailer(true);

    try {
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

        // Agregar imagen embebida
        $mail->AddEmbeddedImage(__DIR__ . '/../Images/regalo.gif', 'regalo', 'regalo.gif', 'base64', 'image/gif');

        // Cargar y modificar el contenido del correo
        $body = file_get_contents('../view/index.php');
        $body = str_replace('src=""', 'src="cid:regalo"', $body); // Reemplaza el src vacío por cid:regalo

        $mail->Body = $body;

        // Enviar correo
        $mail->send();
        echo "Correo enviado a $nombre ($email)";
    } catch (Exception $e) {
        echo "Error al enviar el correo: " . $mail->ErrorInfo;
    }
} else {
    echo "Hoy no hay cumpleañeros.";
}

mysqli_close($conn);
?>
