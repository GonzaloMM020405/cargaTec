<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idPeriodo = $_POST['id_periodo'];
    $nombrePeriodo = $_POST['nombre_periodo'];

    $sql = "UPDATE periodo SET periodo = '$nombrePeriodo' WHERE id_periodo = '$idPeriodo'";
    $resultado1 = mysqli_query($link, $sql);

    if ($resultado1) {
        header("Location: tablaPeriodo.php");
        exit();
    } else {
        echo "Error al actualizar el Periodo: " . mysqli_error($link);
    }
}

mysqli_close($link);
?>