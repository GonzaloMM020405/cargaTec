<?php
include 'conexion.php'; // Incluye el archivo de conexión a la base de datos que proporcionaste

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtén los datos del formulario
    $idGenero = $_POST['id_genero'];
    $nombreGenero = $_POST['nombre_genero'];

    // Verifica si el ID del género ya existe
    $sqlVerificar = "SELECT COUNT(*) FROM generos WHERE id_genero = '$idGenero'";
    $resultadoVerificar = mysqli_query($link, $sqlVerificar);
    $fila = mysqli_fetch_array($resultadoVerificar);

    if ($fila[0] > 0) {
        echo "El ID del género ya existe. Por favor, elige un ID diferente.";
    } else {
        // Inserta los datos en la tabla 'generos'
        $sql = "INSERT INTO generos (id_genero, genero) VALUES ('$idGenero', '$nombreGenero')";
        $resultado = mysqli_query($link, $sql);

        if ($resultado) {
            echo "Género insertado correctamente.";
        } else {
            echo "Error al insertar el género: " . mysqli_error($link);
        }
    }
}

mysqli_close($link); // Cierra la conexión a la base de datos
?>
