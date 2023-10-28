<?php
include 'conexion.php';

if ($_GET['id_genero']) {
    $idGenero = $_GET['id_genero'];

    // Verificar si existen restricciones de clave externa en la tabla 'alumnos'
    $sqlVerificarAlumnos = "SELECT COUNT(*) FROM alumnos WHERE id_genero = '$idGenero'";
    $resultadoVerificarAlumnos = mysqli_query($link, $sqlVerificarAlumnos);
    $filaAlumnos = mysqli_fetch_array($resultadoVerificarAlumnos);

    // Verificar si existen restricciones de clave externa en la tabla 'maestros'
    $sqlVerificarMaestros = "SELECT COUNT(*) FROM maestros WHERE id_genero = '$idGenero'";
    $resultadoVerificarMaestros = mysqli_query($link, $sqlVerificarMaestros);
    $filaMaestros = mysqli_fetch_array($resultadoVerificarMaestros);

    $mensajeError = "";

    if ($filaAlumnos[0] > 0) {
        $mensajeError .= "El género no puede ser eliminado debido a restricciones de clave externa en la tabla 'alumnos'. ";
    }

    if ($filaMaestros[0] > 0) {
        $mensajeError .= "El género no puede ser eliminado debido a restricciones de clave externa en la tabla 'maestros'. ";
    }

    if (!empty($mensajeError)) {
        // Hay restricciones de clave externa, no es posible eliminar el género
        header("Location: indexAdmin.php?error=$mensajeError");
        exit();
    }

    // Realizar la eliminación del registro en la base de datos
    $sql = "DELETE FROM generos WHERE id_genero = '$idGenero'";
    $resultado = mysqli_query($link, $sql);

    if ($resultado) {
        header("Location: indexAdmin.php");
        exit();
    } else {
        echo "Error al eliminar el género: " . mysqli_error($link);
    }
}

mysqli_close($link);
?>
