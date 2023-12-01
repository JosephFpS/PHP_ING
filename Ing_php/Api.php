<?php
$conn = pg_connect("host=localhost dbname=nombre_de_tu_base_de_datos user=usuario password=contraseña");

if (!$conn) {
    die("Error de conexión");
}

$query = "SELECT * FROM tu_tabla";
$result = pg_query($conn, $query);

$data = array();
while ($row = pg_fetch_assoc($result)) {
    $data[] = $row;
}

// Convertir a JSON
$jsonData = json_encode($data);

// Guardar JSON en un archivo
$file = 'datos.json';
file_put_contents($file, $jsonData);

// Cerrar la conexión a la base de datos
pg_close($conn);

echo "Datos guardados en $file";
?>