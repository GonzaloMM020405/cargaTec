<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_estado = $_POST['id_estado'];

    // Verificar si el ID de estado existe en la base de datos
    $consulta = "SELECT estadoCivil FROM estadocivil WHERE id_estado = '$id_estado'";
    $resultado = mysqli_query($link, $consulta);

    if (mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_array($resultado);
        $nombre_estado = $fila['estadoCivil'];
        echo $nombre_estado; // Devuelve el nombre del estado como respuesta
    } else {
        echo "Error: El ID de estado no existe en la base de datos.";
    }
}