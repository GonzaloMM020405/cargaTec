<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_periodo = $_POST['id_periodo'];
    $nombre_periodo = $_POST['nombre_periodo'];
    $accion = $_POST['accion'];

    // Verificar si el ID de periodo existe en la base de datos
    $consulta = "SELECT * FROM periodo WHERE id_periodo = '$id_periodo'";
    $resultado = mysqli_query($link, $consulta);

    if ($accion === 'insert') {
        if (mysqli_num_rows($resultado) > 0) {
            echo "Error: El ID de periodo ya existe en la base de datos. Use una acción diferente o ingrese un nuevo ID.";
        } else {
            $sql = "INSERT INTO periodo (id_periodo, periodo) VALUES ('$id_periodo', '$nombre_periodo')";
            if (mysqli_query($link, $sql)) {
                echo "Éxito: Registro insertado con éxito.";
            } else {
                echo "Error: " . mysqli_error($link);
            }
        }
    } elseif ($accion === 'eliminar') {
        // Eliminar un periodo existente
        $idPeriodo = $_POST['id_periodo']; // Obtiene el ID del periodo a eliminar

        // Verificar si existen restricciones de clave externa en la tabla 'carga'
        $sqlVerificarCarga = "SELECT COUNT(*) FROM carga WHERE id_periodo = '$idPeriodo'";
        $resultadoVerificarCarga = mysqli_query($link, $sqlVerificarCarga);
        $filaCarga = mysqli_fetch_array($resultadoVerificarCarga);

        // Verificar si existen restricciones de clave externa en la tabla 'muestreo'
        $sqlVerificarMuestreo = "SELECT COUNT(*) FROM muestreo WHERE id_periodo = '$idPeriodo'";
        $resultadoVerificarMuestreo = mysqli_query($link, $sqlVerificarMuestreo);
        $filaMuestreo = mysqli_fetch_array($resultadoVerificarMuestreo);

        $mensajeError = "";

        if ($filaCarga[0] > 0) {
            $mensajeError .= "El periodo no puede ser eliminado debido a restricciones de clave externa en la tabla 'Carga'. ";
        }

        if ($filaMuestreo[0] > 0) {
            $mensajeError .= "El periodo no puede ser eliminado debido a restricciones de clave externa en la tabla 'Muestreo'. ";
        }

        if (!empty($mensajeError)) {
            // Hay restricciones de clave externa, no es posible eliminar el periodo
            header("Location: tablaPeriodo.php?error=$mensajeError");
            exit();
        }

        // Si no hay restricciones de clave externa, procede a eliminar el periodo.
        $sql = "DELETE FROM periodo WHERE id_periodo = '$idPeriodo'";
        $resultado = mysqli_query($link, $sql);

        if ($resultado) {
            header("Location: tablaPeriodo.php");
            exit();
        } else {
            echo "Error al eliminar el periodo: " . mysqli_error($link);
        }
    } elseif ($accion === 'update') {
        if (mysqli_num_rows($resultado) > 0) {
            $sql = "UPDATE periodo SET periodo = '$nombre_periodo' WHERE id_periodo = '$id_periodo'";
            if (mysqli_query($link, $sql)) {
                echo "Éxito: Registro actualizado con éxito.";
            } else {
                echo "Error: " . mysqli_error($link);
            }
        } else {
            echo "Error: El ID de periodo no existe en la base de datos. No se puede actualizar.";
        }
    }
}
?>
