<?php
// Parámetros de conexión
$host = "10.42.3.1679";
$usuario = "ALPHA";
$contrasena = "12369874"; // Cambia esto si tienes una contraseña en tu MySQL
$base_datos = "PruebaAlpha";

// Crear conexión
$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener lista de tablas
$consulta_tablas = "SHOW TABLES";
$resultado_tablas = $conexion->query($consulta_tablas);

echo "<h1>Tablas en la base de datos '$base_datos'</h1>";

if ($resultado_tablas->num_rows > 0) {
    while ($fila = $resultado_tablas->fetch_array()) {
        $tabla = $fila[0];
        echo "<h2>Tabla: $tabla</h2>";

        // Obtener datos de la tabla
        $consulta_datos = "SELECT * FROM `$tabla`";
        $resultado_datos = $conexion->query($consulta_datos);

        if ($resultado_datos->num_rows > 0) {
            echo "<table border='1' cellpadding='5'><tr>";

            // Mostrar encabezados
            while ($col = $resultado_datos->fetch_fields()[0]) {
                foreach ($resultado_datos->fetch_fields() as $campo) {
                    echo "<th>{$campo->name}</th>";
                }
                break;
            }

            // Mostrar datos
            $resultado_datos->data_seek(0); // Volver al inicio
            while ($registro = $resultado_datos->fetch_assoc()) {
                echo "<tr>";
                foreach ($registro as $valor) {
                    echo "<td>$valor</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "La tabla está vacía.<br>";
        }
    }
} else {
    echo "No hay tablas en la base de datos.";
}

$conexion->close();
?>
