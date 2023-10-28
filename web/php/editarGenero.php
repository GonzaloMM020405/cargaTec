<?php
include 'conexion.php';

if ($_GET['id']) {
    $idGenero = $_GET['id'];

    // Obtener los datos del género seleccionado
    $sql = "SELECT * FROM generos WHERE id_genero = '$idGenero'";
    $resultado = mysqli_query($link, $sql);
    $genero = mysqli_fetch_assoc($resultado);

    if ($genero) {
        mysqli_close($link);
        // Mostrar el formulario de edición
        echo '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Editar Género</title>
</head>
<body>
    <h1>Editar Género</h1>
    <form method="post" action="procesarEdicionGenero.php">
        <label for="id_genero">ID del Género:</label>
        <input type="text" id="id_genero" name="id_genero" value="' . $genero['id_genero'] . '" readonly>
        <label for="nombre_genero">Nombre del Género:</label>
        <input type="text" id="nombre_genero" name="nombre_genero" value="' . $genero['genero'] . '" required>
        <button type="submit">Guardar</button>
    </form>
</body>
</html>';
        exit();
    } else {
        echo "Género no encontrado.";
    }
} else {
    echo "ID de género no proporcionado.";
}

mysqli_close($link);
?>
