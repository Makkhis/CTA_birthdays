<?php
require '../controller/conexion.php'; // Incluye el archivo de conexión

// Obtener la fecha de hoy (mes y día)
$fecha_hoy = date("m-d");

// Consulta para obtener el nombre del cumpleañero
$sql = "SELECT name FROM user WHERE DATE_FORMAT(birthday, '%m-%d') = '$fecha_hoy' LIMIT 1";
$result = mysqli_query($conn, $sql);
$nombre = "";

if ($row = mysqli_fetch_assoc($result)) {
    $nombre = $row['name'];
} else {
    $nombre = ""; // Si no hay cumpleañero, se muestra "Invitado"
}



mysqli_close($conn);



?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Felicitación de Cumpleaños</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f9f9f9; font-family: 'Lora', serif;">
    <table style="max-width: 600px; width: 100%; margin: auto; background-color: #ffffff; border-collapse: collapse;">
        <tr>
            <td style="padding: 20px; text-align: center;">
                <h1 style="color: #333; font-size: 24px; margin: 0;">🎉 ¡Feliz Cumpleaños! 🎉 <span style="color: #e67e22; font-weight: bold;"><?php echo htmlspecialchars($nombre); ?></span></h1>
                <img src="" alt="Regalo" width="300" style="margin: 20px 0;">
                <p style="color: #555; font-size: 16px; margin: 10px 0;">Hoy es un día especial para ti, y queremos que sepas cuánto valoramos tu presencia en nuestro equipo. ¡Disfruta tu día al máximo! 🎂</p>
                <p style="color:#666; font-size:14px; font-style:italic; margin: 10px 0;">Saludos cordiales, <br>El equipo de CTA</p>
                <h2 style="color: #333; font-size: 20px; margin-top: 20px;">🎁 ¡Sorpresa! 🎁</h2>
                <h3 style="color: #e67e22; font-size: 18px; margin: 5px 0;">Cupón válido para unas galletas hechas a mano 🍪</h3>
            </td>
        </tr>
        <tr>
            <td style="padding: 15px; text-align: center; font-size: 12px; color: #888;">
                <p style="margin: 5px 0;">Recibes este correo porque formas parte de nuestro equipo y queremos celebrar contigo. 🎉</p>
            </td>
        </tr>
    </table>
</body>
</html>