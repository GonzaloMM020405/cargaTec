<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $num_Control = $_POST['num_Control'];
    $nombre_a = $_POST['nombre_a'];
    $paterno_a = $_POST['paterno_a'];
    $materno_a = $_POST['materno_a'];
    $correo_its = $_POST['correo_its'];
    $celular = $_POST['celular'];
    $id_estado = $_POST['id_estado'];
    $id_genero = $_POST['id_genero'];
    $id_carrera = $_POST['id_carrera'];

    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';

    $consulta = "SELECT * FROM alumnos WHERE num_Control = '$num_Control'";
    $resultado = mysqli_query($link, $consulta);

    // Verificar la  a realizar
    if ($accion === 'insert') {
        if (mysqli_num_rows($resultado) > 0) {
            echo "Error: El ID de género ya existe en la base de datos. Use una acción diferente o ingrese un nuevo ID.";
        } else {
            $sql = "INSERT INTO alumnos (num_Control, nombre_a, paterno_a, materno_a, correo_its, celular, id_estado, id_genero, id_carrera) 
                  VALUES ('$num_Control', '$nombre_a', '$paterno_a', '$materno_a', '$correo_its', '$celular', '$id_estado', '$id_genero', '$id_carrera')";

        if (mysqli_query($link, $sql)) {
            echo "Éxito: Alumno insertado con éxito.";
        } else {
            echo "Error: " . mysqli_error($link);
        }
      }
    } elseif ($accion === 'eliminar') {

        // Eliminar un género existente
        $num_Control = $_POST['num_Control']; // Obtiene el ID del género a eliminar

        // Verificar si existen restricciones de clave externa en la tabla 'alumnos'
        $sqlVerificarCarga = "SELECT COUNT(*) FROM carga WHERE num_Control = '$num_Control'";
        $resultadoVerificarCarga = mysqli_query($link, $sqlVerificarCarga);
        $filaCarga = mysqli_fetch_array($resultadoVerificarCarga);    

        $mensajeError = "";

        if ($filaCarga[0] > 0) {
            $mensajeError .= "El género no puede ser eliminado debido a restricciones de clave externa en la tabla 'carga'. ";
        }

        if (!empty($mensajeError)) {
            // Hay restricciones de clave externa, no es posible eliminar el género
            header("Location: tablaAlumnos.php?error=$mensajeError");
            exit();
        }

        // Si no hay restricciones de clave externa, procede a eliminar el género.
        $sql = "DELETE FROM alumnos WHERE num_Control = '$num_Control'";
        $resultado = mysqli_query($link, $sql);

        if ($resultado) {
            exit();
        } else {
            echo "Error al eliminar el Alumno: " . mysqli_error($link);
        }
    } elseif ($accion === 'update') {
        if (mysqli_num_rows($resultado) > 0) {
            $sql = "UPDATE alumnos SET 
                  nombre_a = '$nombre_a', 
                  paterno_a = '$paterno_a', 
                  materno_a = '$materno_a', 
                  correo_its = '$correo_its', 
                  celular = '$celular', 
                  id_estado = '$id_estado', 
                  id_genero = '$id_genero', 
                  id_carrera = '$id_carrera' 
                  WHERE num_Control = '$num_Control'";
    
            if (mysqli_query($link, $sql)) {
                echo "Éxito: Alumno actualizado con éxito.";
            } else {
                echo "Error: " . mysqli_error($link);
            }
        } else {
            echo "Error: El número de control no existe en la base de datos. No se puede actualizar.";
        }
    }
    
}

?>
