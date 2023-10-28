<?php
include 'conexion.php';

if ($_GET['id']) {
    $idGenero = $_GET['id'];

    // Realizar la eliminación del registro en la base de datos
    $sql = "DELETE FROM generos WHERE id_genero = '$idGenero'";
    $resultado = mysqli_query($link, $sql);

    if ($resultado) {
        header("Location: indexAdmin.php");
        exit();
    } else {
        echo "Error al eliminar el género: " . mysqli_error($link);
    }
}

mysqli_close($link);
?>
