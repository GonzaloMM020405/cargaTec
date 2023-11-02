<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idEstado = $_POST['id_estado'];
    $nombreEstado = $_POST['nombre_estado'];

    $sqlVerificar = "SELECT COUNT(*) FROM estadocivil WHERE id_estado = '$idEstado'";
    $resultadoVerificar = mysqli_query($link, $sqlVerificar);
    $fila = mysqli_fetch_array($resultadoVerificar);

    if ($fila[0] > 0) {
        $error = "El ID del estado ya existe. Por favor, elige un ID diferente.";
        header("Location: tablaEstado.php?error=$error");
        exit();
    }

    $sql = "INSERT INTO estadocivil (id_estado, estadoCivil) VALUES ('$idEstado', '$nombreEstado')";
    $resultado = mysqli_query($link, $sql);

    if ($resultado) {
        header("Location: tablaEstado.php");
        exit();
    } else {
        echo "Error al insertar el estado civíl: " . mysqli_error($link);
    }
}

mysqli_close($link);
?>