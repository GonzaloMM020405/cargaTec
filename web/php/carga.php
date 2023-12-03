<?php
session_start();
// Si la sesión 'nombre_usuario' está establecida, muestra el mensaje de bienvenida
if (isset($_SESSION['nombre_usuario'])) {
    $num_Control = $_SESSION['nombre_usuario'];
    echo "<p>Bienvenido, $num_Control</p>";
} else {
    // Redirige a la página de inicio de sesión si no hay nombre de usuario en la sesión
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carga Académica</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Selección de Materias</h1>
<!-- Formulario para seleccionar materias -->
<!-- Formulario para seleccionar materias -->
<form action="procesarCarga.php" method="post">
    <h2>Materias Disponibles</h2>
    <?php
    include_once 'conexion.php';

    $mensaje = '';
    if (isset($_SESSION['mensaje'])) {
        $mensaje = $_SESSION['mensaje'];
        unset($_SESSION['mensaje']); // Limpiar el mensaje para que no se muestre en futuras recargas de la página
    }

    $num_Control = $_SESSION['nombre_usuario'];
    $materias = obtenerMateriasDisponibles();

    echo '<table>';
    echo '<tr><th>Materia</th><th>ID Hora</th><th>ID Maestro</th><th>ID Periodo</th><th>ID Salón</th><th>Carrera</th><th>Maestro</th><th>Periodo</th><th>Seleccionar</th></tr>';
    for ($i = 0; $i < count($materias); $i++) {
        echo '<tr>';
        echo '<td>' . $materias[$i]['nombre_mat'] . '</td>';
        echo '<td>' . $materias[$i]['id_hora'] . '</td>';
        echo '<td>' . $materias[$i]['id_maestro'] . '</td>';
        echo '<td>' . $materias[$i]['id_periodo'] . '</td>';
        echo '<td>' . $materias[$i]['id_salon'] . '</td>';
        echo '<td>' . $materias[$i]['nombre_carrera'] . '</td>';
        echo '<td>' . $materias[$i]['nombre_m'] . ' ' . $materias[$i]['paterno_m'] . ' ' . $materias[$i]['materno_m'] . '</td>';
        echo '<td>' . $materias[$i]['periodo'] . '</td>';
        echo '<td>' . $num_Control . '</td>';
        echo '<td>';
        echo '<input type="hidden" name="num_Control" value="' . $num_Control . '">';
        echo '<input type="hidden" name="id_salon_' . $i . '" value="' . $materias[$i]['id_salon'] . '">';
        echo '<input type="hidden" name="id_periodo_' . $i . '" value="' . $materias[$i]['id_periodo'] . '">';
        echo '<input type="hidden" name="id_maestro_' . $i . '" value="' . $materias[$i]['id_maestro'] . '">';
        echo '<input type="hidden" name="id_hora_' . $i . '" value="' . $materias[$i]['id_hora'] . '">';
        echo '<input type="hidden" name="id_materia_' . $i . '" value="' . $materias[$i]['id_materia'] . '">';
        echo '<input type="hidden" name="id_carrera_' . $i . '" value="' . $materias[$i]['id_carrera'] . '">';
        echo '<input type="hidden" name="selectedRow" value="'.$i.'">';
        echo '<button type="submit" name="guardarCarga" value="' . $i . '">Seleccionar</button>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '<p style="color: green;">' . $mensaje . '</p>';
    ?>
</form>

    <form action="deleteCarga.php" method="post">
    <h2>Carga Académica Actual</h2>
    <?php
include_once 'conexion.php';
$num_Control = $_SESSION['nombre_usuario'];
$carga = obtenerCarga();

        echo '<table>';
        echo '<tr><th>ID Materia</th><th>Nombre Materia</th><th>ID Hora</th><th>ID Maestro</th><th>ID Periodo</th><th>ID Salón</th><th>Carrera</th><th>Maestro</th><th>Periodo</th></tr>';
        for ($i = 0; $i < count($carga); $i++) {
            echo '<tr>';
            echo '<td>' . $carga[$i]['id_carrera'] . '</td>';
            echo '<td>' . $carga[$i]['id_materia'] . '</td>';
            echo '<td>' . $carga[$i]['nombre_mat'] . '</td>';
            echo '<td>' . $carga[$i]['id_hora'] . '</td>';
            echo '<td>' . $carga[$i]['id_maestro'] . '</td>';
            echo '<td>' . $carga[$i]['id_periodo'] . '</td>';
            echo '<td>' . $carga[$i]['id_salon'] . '</td>';
            echo '<td>' . $carga[$i]['nombre_carrera'] . '</td>';
            echo '<td>' . $carga[$i]['nombre_m'] . ' ' . $carga[$i]['paterno_m'] . ' ' . $carga[$i]['materno_m'] . '</td>';
            echo '<td>' . $carga[$i]['periodo'] . '</td>';
            echo '<td>';
        echo '<input type="hidden" name="id_carrera_' . $i . '" value="' . $carga[$i]['id_carrera'] . '">';
        echo '<input type="hidden" name="id_materia_' . $i . '" value="' . $carga[$i]['id_materia'] . '">';
        echo '<input type="hidden" name="id_hora_' . $i . '" value="' . $carga[$i]['id_hora'] . '">';
        echo '<input type="hidden" name="id_maestro_' . $i . '" value="' . $carga[$i]['id_maestro'] . '">';
        echo '<input type="hidden" name="id_periodo_' . $i . '" value="' . $carga[$i]['id_periodo'] . '">';
        echo '<input type="hidden" name="id_salon_' . $i . '" value="' . $carga[$i]['id_salon'] . '">';
        echo '<input type="hidden" name="selectedRow" value="'.$i.'">';
            echo '<button type="submit" name="deleteCarga" value="' . $i . '">Eliminar</button>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    ?>
    </form>
</body>   
</html>


