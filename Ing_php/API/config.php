<?php
// Configuración de la base de datos
$host = "localhost";
$dbname = "dbphp";
$username = "postgres";
$password = "1234";

// Establecer conexión a la base de datos
$conn = pg_connect("host=$host dbname=$dbname user=$username password=$password");

// Verificar la conexión
if (!$conn) {
    http_response_code(500); // Error interno del servidor
    echo json_encode(array("error" => "Error de conexión a la base de datos"));
    exit;
}
?>