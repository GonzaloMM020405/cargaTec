<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_periodo = $_POST['id_periodo'];

    // Verificar si el ID de periodo existe en la base de datos
    $consulta = "SELECT periodo FROM periodo WHERE id_periodo = '$id_periodo'";
    $resultado = mysqli_query($link, $consulta);

    if (mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_array($resultado);
        $nombre_periodo = $fila['periodo'];
        echo $nombre_periodo; // Devuelve el nombre del periodo como respuesta
    } else {
        echo "Error: El ID de periodo no existe en la base de datos.";
    }
}