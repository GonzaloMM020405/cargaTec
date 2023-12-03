<?php
session_start();
include 'conexion.php';
echo '<pre>';
print_r($_POST);
echo '</pre>';
    // Obtener los valores desde la solicitud POST
    $num_Control = $_SESSION['nombre_usuario'];
    $selectedRow = $_POST['deleteCarga'];
    $id_salon = $_POST['id_salon_' . $selectedRow];
    $id_periodo = $_POST['id_periodo_' . $selectedRow];
    $id_maestro = $_POST['id_maestro_' . $selectedRow];
    $id_hora = $_POST['id_hora_' . $selectedRow];
    $id_materia = $_POST['id_materia_' . $selectedRow];
    $id_carrera = $_POST['id_carrera_' . $selectedRow];

    // Construir la consulta de eliminación
    $query = "DELETE FROM carga WHERE num_Control = '$num_Control' AND id_salon = '$id_salon' AND id_periodo = '$id_periodo' AND id_maestro = '$id_maestro' AND id_hora = '$id_hora' AND id_materia = '$id_materia' AND id_carrera = '$id_carrera'";
    mysqli_query($link, $query);

    

    header('Location: carga.php');
    exit();
?>
