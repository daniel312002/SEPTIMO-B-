<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tablas de la base de datos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 40px;
        }
        th, td {
            border: 1px solid #444;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #ddd;
        }
    </style>
</head>
<body>

<?php
// Parámetros de conexión
$host = "10.42.3.167";
$usuario = "ALPHA";
$contrasena = "12369874";
$base_datos = "PruebaAlpha";

// Crear conexión
$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificar conexión
if ($conexion->connect_error) {
    die("<p>Error de conexión: " . $conexion->connect_error . "</p>");
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
            echo "<table><tr>";

            // Encabezados
            foreach ($resultado_datos->fetch_fields() as $campo) {
                echo "<th>{$campo->name}</th>";
            }
            echo "</tr>";

            // Datos
            while ($registro = $resultado_datos->fetch_assoc()) {
                echo "<tr>";
                foreach ($registro as $valor) {
                    echo "<td>$valor</td>";
                }
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>La tabla está vacía.</p>";
        }
    }
} else {
    echo "<p>No hay tablas en la base de datos.</p>";
}

$conexion->close();
?>

</body>
</html>

