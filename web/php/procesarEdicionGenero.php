<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idGenero = $_POST['id_genero'];
    $nombreGenero = $_POST['nombre_genero'];

    $sql = "UPDATE generos SET genero = '$nombreGenero' WHERE id_genero = '$idGenero'";
    $resultado = mysqli_query($link, $sql);

    if ($resultado) {
        header("Location: indexAdmin.php");
        exit();
    } else {
        echo "Error al actualizar el género: " . mysqli_error($link);
    }
}

mysqli_close($link);
?>
