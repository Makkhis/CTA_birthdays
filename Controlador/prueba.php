<?php
require 'conexion.php';

$fecha_hoy = date("m-d");

$sql = "SELECT namee, email FROM user WHERE DATE_FORMAT(cumpleanios, '%m-%d') = '$fecha_hoy'";

$result= mysqli_query($conn, $sql);
if(mysqli_num_rows($result)> 0){
    while($row=mysqli_fetch_assoc($result)){
        echo"El mensaje de feliz cumple se le enviara a " . $row['namee'] . " al correo " . $row['email'] . "<br>";
    }
}else{echo"No hay quienceañera hoy";}

mysqli_close($conn);


?>