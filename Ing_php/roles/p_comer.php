<?php
include('../conexion.php'); 

// Crear una instancia de la clase Conexion
$instanciaConexion = new Conexion();

// Obtener la conexión a la base de datos
$conexion = $instanciaConexion->ConexionBD();

if (!$conexion) {
    echo "Error al conectar a la base de datos. <br>";
    exit;
}

// Recuperar el ID del usuario de la URL
$user_id = $_GET['user_id'];

// Realizar una consulta para obtener la información del usuario
$consulta_usuario = pg_query($conexion, "SELECT * FROM usuarios WHERE id='$user_id'");
$consulta_recaudos = pg_query($conexion, "SELECT * FROM recaudos WHERE id_usuario='$user_id'");

if (!$consulta_usuario) {
    echo "Error al ejecutar la consulta. <br>";
    exit;
}

if ($row_usuario = pg_fetch_array($consulta_usuario)) {

    echo "Bienvenido, " . $row_usuario['usuario'] . "<br>";
    echo "Su rol es, " . $row_usuario['rol'] . "<br>";

} else {

    echo "Error: No se pudo obtener la información del usuario.";
}

pg_close($conexion);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Generar Factura</title>
</head>

<body>
<section id="inicio" class="inicio">
        <div class="contenido-banner">
            <!-- Formulario con un botón para generar la factura -->
            <label for="miCajaTexto">Obtener Recaudo</label>
            <button type="button" onclick="autollenar()">Ver</button>
            <br>
            <table class="table table-hover" style="max-width: 600px;">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID RECAUDO</th>
                    <th scope="col">ID USUARIO</th>
                    <th scope="col">FECHA DEL RECAUDO</th>
                    <th scope="col">MONTO</th>
                </tr>
            </thead>

                <?php
                    while( $row = pg_fetch_assoc($consulta_recaudos)) {
                        echo "
                        <tr>
                            <td>$row[id_recaudo]</td>
                            <td>$row[id_usuario]</td>
                            <td>$row[fecha_recaudo]</td>
                            <td>$row[monto_recaudado]</td>
                        
                        </tr>
                        
                        
                        ";

                    }
                
                
                ?>
            </table>
            
        </div>
    </section>

    <script>
        // Función para autollenar la caja de texto al hacer clic en el botón
        function autollenar() {
            document.getElementById("miCajaTexto").value = "Texto autollenado";
        }
    </script>

</body>

</html>