<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idGenero = $_POST['id_genero'];
    $nombreGenero = $_POST['nombre_genero'];

    $sqlVerificar = "SELECT COUNT(*) FROM generos WHERE id_genero = '$idGenero'";
    $resultadoVerificar = mysqli_query($link, $sqlVerificar);
    $fila = mysqli_fetch_array($resultadoVerificar);

    if ($fila[0] > 0) {
        $error = "El ID del género ya existe. Por favor, elige un ID diferente.";
        header("Location: indexAdmin.php?error=$error");
        exit();
    }

    $sql = "INSERT INTO generos (id_genero, genero) VALUES ('$idGenero', '$nombreGenero')";
    $resultado = mysqli_query($link, $sql);

    if ($resultado) {
        header("Location: indexAdmin.php");
        exit();
    } else {
        echo "Error al insertar el género: " . mysqli_error($link);
    }
}

mysqli_close($link);
?>
