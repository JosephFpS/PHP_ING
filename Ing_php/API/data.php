<?php
require_once 'config.php';
$method = $_SERVER['REQUEST_METHOD'] ?? '';

switch ($method) {
    case 'GET':
        // Obtener datos de la base de datos
        $query = "SELECT * FROM recaudos";
        $result = pg_query($conn, $query);

        if (!$result) {
            http_response_code(500);
            echo json_encode(array("error" => "Error al ejecutar la consulta"));
            exit;
        }

        $data = array();
        while ($row = pg_fetch_assoc($result)) {
            $data[] = $row;
        }

        echo json_encode($data);
        break;
    case 'POST':
        // Recibir datos y agregar un nuevo elemento a la base de datos
        $inputJSON = file_get_contents('php://input');
        $inputData = json_decode($inputJSON, true);

        // Validar datos (ejemplo: verificar que los campos requeridos estén presentes)
        if (!is_array($inputData)) {
            http_response_code(400);  // Bad Request
            echo json_encode(array("error" => "Los datos proporcionados no son válidos"));
            exit;
        }

        // Formatear la fecha en el formato correcto
        // Agregar nuevo dato a la base de datos
        $columns = implode(", ", array_keys($inputData [0]));
        $values = array_map(function ($value) use ($conn) {
            echo implode(',',$value);
            return pg_escape_string($conn, implode(',',$value));
        }, $inputData);
        echo "Columnas: $columns\n";
       // echo "Valores: " . implode(", ", $values)[3] . "\n";
        echo "Valores: " . $values[0][0];        //echo "Columnas: $columns";
        //echo $values[0]['id_usuario'];
        $insertQuery = "INSERT INTO recaudos ($columns) VALUES (" . implode(", ", $values) . ")";
        
        // $insertQuery = "INSERT INTO recaudos (id_recaudo, id_usuario, fecha_recaudo, monto_recaudado) VALUES ('$values[id_recaudo]',
        //     '$values[id_usuario]',
        //     '$values[fecha_recaudo]',
        //     '$values[monto_recaudado]')";
        $insertResult = pg_query($conn, $insertQuery);
        
        if (!$insertResult) {
            http_response_code(500);
            echo json_encode(array("error" => "Error al insertar datos en la base de datos: " . pg_last_error($conn)));
            exit;
        }
        
        echo json_encode(array("success" => "Dato agregado correctamente"));
        break;
    default:
        http_response_code(405);
        echo json_encode(array("error" => "Método no permitido"));
        break;
}

// Cerrar la conexión a la base de datos
pg_close($conn);
?>