<?php
require '../Controlador/conexion.php'; // Incluye el archivo de conexión

// Obtener la fecha de hoy (mes y día)
$fecha_hoy = date("m-d");

// Consulta para obtener el nombre del cumpleañero
$sql = "SELECT namee FROM user WHERE DATE_FORMAT(cumpleanios, '%m-%d') = '$fecha_hoy' LIMIT 1";
$result = mysqli_query($conn, $sql);
$nombre = "";

if ($row = mysqli_fetch_assoc($result)) {
    $nombre = $row['namee'];
} else {
    $nombre = ""; // Si no hay cumpleañero, se muestra "Invitado"
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es" dir="ltr" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title>Felicitación de Cumpleaños</title>
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> <!-- Archivo de estilos -->
</head>
<body>
    <div class="container">
        <h1>🎉 ¡Feliz Cumpleaños! 🎉 <span class="nombre-cumpleanero"><?php echo htmlspecialchars($nombre); ?></span></h1>
        <img src="https://tlr.stripocdn.email/content/guids/CABINET_b54797fc68edcecf4f6b2835e7bcba32/images/36321522405737710.gif" alt="Regalo" title="Regalo" width="300">
        <p>Hoy es un día especial para ti, y queremos que sepas cuánto valoramos tu presencia en nuestro equipo. ¡Disfruta tu día al máximo! 🎂</p>
        <p style="color:#666;font-size:14px; font-style:italic;">Saludos cordiales, <br>El equipo de Run CTA</p>
        
        <div class="surprise">
            <h2>🎁 ¡Sorpresa! 🎁</h2>
            <h3>Cupón válido para unas galletas hecha a mano 🍪</h3>
        </div>
        
        <footer>
            <p>&copy; 2025 CTA</p>
            <p>Recibes este correo porque formas parte de nuestro equipo y queremos celebrar contigo. 🎉</p>
        </footer>
    </div>
</body>
</html>


