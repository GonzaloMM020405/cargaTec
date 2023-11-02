<?php
include 'conexion.php';

if ($_GET['id_estado']) {
    $idEstado = $_GET['id_estado'];

    // Verificar si existen restricciones de clave externa en la tabla 'Maestros'
    $sqlVerificarMaestros = "SELECT COUNT(*) FROM maestros WHERE id_estado = '$idEstado'";
    $resultadoVerificarMaestros = mysqli_query($link, $sqlVerificarMaestros);
    $filaMaestros = mysqli_fetch_array($resultadoVerificarMaestros);

    // Verificar si existen restricciones de clave externa en la tabla 'Alumnos'
    $sqlVerificarAlumnos = "SELECT COUNT(*) FROM alumnos WHERE id_estado = '$idEstado'";
    $resultadoVerificarAlumnos = mysqli_query($link, $sqlVerificarAlumnos);
    $filaAlumnos = mysqli_fetch_array($resultadoVerificarAlumnos);

    $mensajeError = "";

    if ($filaMaestros[0] > 0) {
        $mensajeError .= "El estado civil no puede ser eliminado debido a restricciones de clave externa en la tabla 'Maestros'. ";
    }

    if ($filaAlumnos[0] > 0) {
        $mensajeError .= "El estado civil no puede ser eliminado debido a restricciones de clave externa en la tabla 'Alumnos'. ";
    }

    if (!empty($mensajeError)) {
        // Hay restricciones de clave externa, no es posible eliminar el estado civil
        header("Location: tablaEstado.php?error=$mensajeError");
        exit();
    }

    // Realizar la eliminación del registro en la base de datos
    $sql = "DELETE FROM estadocivil WHERE id_estado = '$idEstado'";
    $resultado2 = mysqli_query($link, $sql);

    if ($resultado2) {
        header("Location: tablaEstado.php");
        exit();
    } else {
        echo "Error al eliminar el estado civíl: " . mysqli_error($link);
    }
}

mysqli_close($link);
?>