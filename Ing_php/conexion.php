<?php
class Conexion {
    public static function ConexionBD() {
        $host = "localhost";
        $dbname = "dbphp";
        $username = "postgres";
        $password = "1234";

        try {
            $conexion = pg_connect("host=$host dbname=$dbname user=$username password=$password");
            if (!$conexion) {
                throw new Exception('Error al conectar a la base de datos.');
            }

        } catch (Exception $exp) {
            echo "No se pudo conectar a la base de datos. $exp";
            exit;
        }

        return $conexion;
    }
}
?>
