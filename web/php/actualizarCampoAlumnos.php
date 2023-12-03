<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $num_Control = $_POST['num_Control'];

    // Verificar si el ID de género existe en la base de datos
    $consulta = "SELECT id_estado, id_genero, id_carrera, nombre_a, paterno_a, materno_a, correo_its, celular FROM alumnos WHERE num_Control = '$num_Control'";
    $resultado = mysqli_query($link, $consulta);

    if (mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_array($resultado);

        // Crear un array asociativo con los datos
        $datos = array(
            'id_estado' => $fila['id_estado'],
            'id_genero' => $fila['id_genero'],
            'id_carrera' => $fila['id_carrera'],
            'nombre_a' => $fila['nombre_a'],
            'paterno_a' => $fila['paterno_a'],
            'materno_a' => $fila['materno_a'],
            'correo_its' => $fila['correo_its'],
            'celular' => $fila['celular']
        );

        // Convertir el array a formato JSON
        echo json_encode($datos);
    } else {
        echo "Error: El ID de género no existe en la base de datos.";
    }
}
?>
