<?php
   $usuario = $_POST['user'];
   $clave = $_POST['pass'];
   
   // Establecer conexión a la base de datos
   $conexion = pg_connect("host=localhost dbname=dbphp user=postgres password=1234");
   
   // Verificar la conexión
   if (!$conexion) {
      echo "Error al conectar a la base de datos. <br>";
      exit;
   }

   // Realizar la consulta para obtener el usuario
   $consulta = pg_query($conexion, "SELECT * FROM usuarios WHERE usuario='$usuario' AND contrasena='$clave'");
   
   // Verificar la ejecución de la consulta
   if (!$consulta) {
      echo "Error al ejecutar la consulta. <br>";
      exit;
   }

   // Verificar si se encontró el usuario
   if ($row = pg_fetch_array($consulta)) {
      // Autenticación exitosa
      $rol = $row['rol'];
      $user_id = $row['id'];

      // Redirigir según el rol
      switch ($rol) {
          case "Administrativo":
              $redirect_url = "/Prueba_Conexion/roles/p_admin.php?user_id=$user_id";
              break;
          case "Gerente":
              $redirect_url = "/Prueba_Conexion/roles/p_geren.php?user_id=$user_id";
              break;
          case "Comercial":
              $redirect_url = "/Prueba_Conexion/roles/p_comer.php?user_id=$user_id";
              break;
          case "Mozo de almacen":
              $redirect_url = "/Prueba_Conexion/roles/p_almac.php?user_id=$user_id";
              break;
          default:
              // Si el rol no coincide con ninguno de los anteriores, puedes redirigir a una página por defecto
              $redirect_url = "pagina_por_defecto.php";
      }
  
      // Redirigir al usuario a la página correspondiente
      header("Location: $redirect_url");
      exit();
   } else {
      // Autenticación fallida
      echo "Error: Usuario o contraseña incorrectos.";
   }
?>
