<?php
include 'conexion.php';

if ($_GET['id_periodo']) {
    $idPeriodo = $_GET['id_periodo'];

    // Verificar si existen restricciones de clave externa en la tabla 'alumnos'
    $sqlVerificarMuestreo = "SELECT COUNT(*) FROM muestreo WHERE id_periodo = '$idPeriodo'";
    $resultadoVerificarMuestreo = mysqli_query($link, $sqlVerificarMuestreo);
    $filaMuestreo = mysqli_fetch_array($resultadoVerificarMuestreo);

    // Verificar si existen restricciones de clave externa en la tabla 'carga'
    $sqlVerificarCarga = "SELECT COUNT(*) FROM carga WHERE id_periodo = '$idperiodo'";
    $resultadoVerificarCarga = mysqli_query($link, $sqlVerificarCarga);
    $filaCarga = mysqli_fetch_array($resultadoVerificarCarga);

    $mensajeError = "";

    if ($filaMuestreo[0] > 0) {
        $mensajeError .= "El periodo no puede ser eliminado debido a restricciones de clave externa en la tabla 'Muestreo'. ";
    }

    if ($filaCarga[0] > 0) {
        $mensajeError .= "El periodo no puede ser eliminado debido a restricciones de clave externa en la tabla 'Carga'. ";
    }

    if (!empty($mensajeError)) {
        // Hay restricciones de clave externa, no es posible eliminar el periodo
        header("Location: tablaPeriodo.php?error=$mensajeError");
        exit();
    }

    // Realizar la eliminación del registro en la base de datos
    $sql = "DELETE FROM periodo WHERE id_periodo = '$idPeriodo'";
    $resultado1 = mysqli_query($link, $sql);

    if ($resultado1) {
        header("Location: tablaPeriodo.php");
        exit();
    } else {
        echo "Error al eliminar el periodo: " . mysqli_error($link);
    }
}

mysqli_close($link);
?>