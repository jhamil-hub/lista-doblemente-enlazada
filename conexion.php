<?php
$host     = "localhost";
$usuario  = "root";
$password = "";
$baseDatos = "bd";
$puerto   = 3308;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conexion = new mysqli($host, $usuario, $password, $baseDatos, $puerto);
    $conexion->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    die("<h3>Error de conexión a la base de datos</h3><p>" . htmlspecialchars($e->getMessage()) .
        "</p><p>Verifica que MySQL esté iniciado en XAMPP y que la base de datos <b>bd</b> exista.</p>");
}
