<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idPeriodo = $_POST['id_periodo'];
    $nombrePeriodo = $_POST['nombre_periodo'];

    $sqlVerificar = "SELECT COUNT(*) FROM periodo WHERE id_periodo = '$idPeriodo'";
    $resultadoVerificar = mysqli_query($link, $sqlVerificar);
    $fila = mysqli_fetch_array($resultadoVerificar);

    if ($fila[0] > 0) {
        $error = "El ID del periodo ya existe. Por favor, elige un ID diferente.";
        header("Location: tablaPeriodo.php?error=$error");
        exit();
    }

    $sql = "INSERT INTO periodo (id_periodo, periodo) VALUES ('$idPeriodo', '$nombrePeriodo')";
    $resultado = mysqli_query($link, $sql);

    if ($resultado) {
        header("Location: tablaPeriodo.php");
        exit();
    } else {
        echo "Error al insertar el periodo: " . mysqli_error($link);
    }
}

mysqli_close($link);
?>
