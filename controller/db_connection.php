<!DOCTYPE html>
<html lang="es">
    <?php 
    require __DIR__ .'/../vendor/autoload.php';

    use Dotenv\Dotenv;

    //carar el .env
    $dotenv = Dotenv::createImmutable(__DIR__ .'/..');
    $dotenv->load();
    
    $host = $_ENV['DB_HOST'];
    $user = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASSWORD'];
    $dbname = $_ENV['DB_NAME'];

    // Crear conexión
    $conn = mysqli_connect($host, $user, $password, $dbname);

    
    

?>

</html>