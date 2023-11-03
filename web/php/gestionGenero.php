<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_genero = $_POST['id_genero'];
    $nombre_genero = $_POST['nombre_genero'];
    $accion = $_POST['accion'];

    // Verificar si el ID de género existe en la base de datos
    $consulta = "SELECT * FROM generos WHERE id_genero = '$id_genero'";
    $resultado = mysqli_query($link, $consulta);

    if ($accion === 'insert') {
        if (mysqli_num_rows($resultado) > 0) {
            echo "Error: El ID de género ya existe en la base de datos. Use una acción diferente o ingrese un nuevo ID.";
        } else {
            $sql = "INSERT INTO generos (id_genero, genero) VALUES ('$id_genero', '$nombre_genero')";
            if (mysqli_query($link, $sql)) {
                echo "Éxito: Registro insertado con éxito.";
            } else {
                echo "Error: " . mysqli_error($link);
            }
        }
    } elseif ($accion === 'eliminar') {
        // Eliminar un género existente
        $idGenero = $_POST['id_genero']; // Obtiene el ID del género a eliminar

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
            header("Location: tablaGenero.php?error=$mensajeError");
            exit();
        }

        // Si no hay restricciones de clave externa, procede a eliminar el género.
        $sql = "DELETE FROM generos WHERE id_genero = '$idGenero'";
        $resultado = mysqli_query($link, $sql);

        if ($resultado) {
            header("Location: tablaGenero.php");
            exit();
        } else {
            echo "Error al eliminar el género: " . mysqli_error($link);
        }
    } elseif ($accion === 'update') {
        if (mysqli_num_rows($resultado) > 0) {
            $sql = "UPDATE generos SET genero = '$nombre_genero' WHERE id_genero = '$id_genero'";
            if (mysqli_query($link, $sql)) {
                echo "Éxito: Registro actualizado con éxito.";
            } else {
                echo "Error: " . mysqli_error($link);
            }
        } else {
            echo "Error: El ID de género no existe en la base de datos. No se puede actualizar.";
        }
    }
}
?>
