<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_estado = $_POST['id_estado'];
    $nombre_estado = $_POST['nombre_estado'];
    $accion = $_POST['accion'];

    // Verificar si el ID del estado civil existe en la base de datos
    $consulta = "SELECT * FROM estadocivil WHERE id_estado = '$id_estado'";
    $resultado = mysqli_query($link, $consulta);

    if ($accion === 'insert') {
        if (mysqli_num_rows($resultado) > 0) {
            echo "Error: El ID del estado civil ya existe en la base de datos. Use una acción diferente o ingrese un nuevo ID.";
        } else {
            $sql = "INSERT INTO estadocivil (id_estado, estadoCivil) VALUES ('$id_estado', '$nombre_estado')";
            if (mysqli_query($link, $sql)) {
                echo "Éxito: Registro insertado con éxito.";
            } else {
                echo "Error: " . mysqli_error($link);
            }
        }
    } elseif ($accion === 'eliminar') {
        // Eliminar un estado civil existente
        $idEstado = $_POST['id_estado']; // Obtiene el ID del estado a eliminar

        // Verificar si existen restricciones de clave externa en la tabla 'alumnos'
        $sqlVerificarAlumnos = "SELECT COUNT(*) FROM alumnos WHERE id_estado = '$idEstado'";
        $resultadoVerificarAlumnos = mysqli_query($link, $sqlVerificarAlumnos);
        $filaAlumnos = mysqli_fetch_array($resultadoVerificarAlumnos);

        // Verificar si existen restricciones de clave externa en la tabla 'maestros'
        $sqlVerificarMaestros = "SELECT COUNT(*) FROM maestros WHERE id_estado = '$idEstado'";
        $resultadoVerificarMaestros = mysqli_query($link, $sqlVerificarMaestros);
        $filaMaestros = mysqli_fetch_array($resultadoVerificarMaestros);

        $mensajeError = "";

        if ($filaAlumnos[0] > 0) {
            $mensajeError .= "El estado civil no puede ser eliminado debido a restricciones de clave externa en la tabla 'alumnos'. ";
        }

        if ($filaMaestros[0] > 0) {
            $mensajeError .= "El estado civil no puede ser eliminado debido a restricciones de clave externa en la tabla 'maestros'. ";
        }

        if (!empty($mensajeError)) {
            // Hay restricciones de clave externa, no es posible eliminar el estado
            header("Location: tablaEstado.php?error=$mensajeError");
            exit();
        }

        // Si no hay restricciones de clave externa, procede a eliminar el estado.
        $sql = "DELETE FROM estadocivil WHERE id_estado = '$idEstado'";
        $resultado = mysqli_query($link, $sql);

        if ($resultado) {
            header("Location: tablaEstado.php");
            exit();
        } else {
            echo "Error al eliminar el estado civil: " . mysqli_error($link);
        }
    } elseif ($accion === 'update') {
        if (mysqli_num_rows($resultado) > 0) {
            $sql = "UPDATE estadocivil SET estadoCivil = '$nombre_estado' WHERE id_estado = '$id_estado'";
            if (mysqli_query($link, $sql)) {
                echo "Éxito: Registro actualizado con éxito.";
            } else {
                echo "Error: " . mysqli_error($link);
            }
        } else {
            echo "Error: El ID del estado civil no existe en la base de datos. No se puede actualizar.";
        }
    }
}
?>