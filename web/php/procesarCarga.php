<?php
session_start();
include 'conexion.php';
echo '<pre>';
print_r($_POST);
echo '</pre>';


$num_Control = $_SESSION['nombre_usuario'];
$selectedRow = $_POST['guardarCarga'];
$id_salon = $_POST['id_salon_' . $selectedRow];
$id_periodo = $_POST['id_periodo_' . $selectedRow];
$id_maestro = $_POST['id_maestro_' . $selectedRow];
$id_hora = $_POST['id_hora_' . $selectedRow];
$id_materia = $_POST['id_materia_' . $selectedRow];
$id_carrera = $_POST['id_carrera_' . $selectedRow];

// Verificar si la carga ya existe
$num_Control = $_SESSION['nombre_usuario'];
$query_verificar = "SELECT * FROM carga WHERE num_Control = '$num_Control' AND id_salon = '$id_salon' AND id_periodo = '$id_periodo' AND id_maestro = '$id_maestro' AND id_hora = '$id_hora' AND id_materia = '$id_materia' AND id_carrera = '$id_carrera'";
$result_verificar = mysqli_query($link, $query_verificar);

if (mysqli_num_rows($result_verificar) > 0) {
    $_SESSION['mensaje'] = "¡Ya has seleccionado esa materia! Por favor, elige otra.";
} else {
    // Insertar carga si no existe
    $query_carga = "INSERT INTO carga VALUES ('$num_Control', '$id_salon', '$id_periodo', '$id_maestro', '$id_hora', '$id_materia', '$id_carrera')";
    mysqli_query($link, $query_carga);
    $_SESSION['mensaje'] = "¡Materia seleccionada exitosamente!";
}

// Redirigir a la página principal
header('Location: carga.php');
exit();

?>