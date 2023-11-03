<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idEstado = $_POST['id_estado'];
    $nombreEstado = $_POST['nombre_estado'];

    $sql = "UPDATE estadocivil SET estadoCivil = '$nombreEstado' WHERE id_estado = '$idEstado'";
    $resultado = mysqli_query($link, $sql);

    if ($resultado) {
        header("Location: tablaEstado.php");
        exit();
    } else {
        echo "Error al actualizar el Estado civíl: " . mysqli_error($link);
    }
}

mysqli_close($link);
?>