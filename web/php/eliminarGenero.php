<?php
include 'conexion.php';

if ($_GET['id_genero']) {
    $idGenero = $_GET['id_genero'];

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
