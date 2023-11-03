<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_genero = $_POST['id_genero'];

    // Verificar si el ID de género existe en la base de datos
    $consulta = "SELECT genero FROM generos WHERE id_genero = '$id_genero'";
    $resultado = mysqli_query($link, $consulta);

    if (mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_array($resultado);
        $nombre_genero = $fila['genero'];
        echo $nombre_genero; // Devuelve el nombre del género como respuesta
    } else {
        echo "Error: El ID de género no existe en la base de datos.";
    }
}
