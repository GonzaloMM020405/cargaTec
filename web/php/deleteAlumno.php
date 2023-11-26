<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['num_Control'])) {
        $num_Control = $_GET['num_Control'];

        // Función para limpiar y escapar los datos
        function limpiarDatos($dato) {
            global $link;
            return mysqli_real_escape_string($link, $dato);
        }

        $num_Control = limpiarDatos($num_Control);

        // Verificar si existen restricciones de clave externa en otras tablas antes de eliminar
        $sqlVerificarOtrasTablas = "SELECT COUNT(*) FROM carga WHERE num_Control = '$num_Control'";
        $resultadoVerificarOtrasTablas = mysqli_query($link, $sqlVerificarOtrasTablas);
        $filaOtrasTablas = mysqli_fetch_array($resultadoVerificarOtrasTablas);

        if ($filaOtrasTablas[0] > 0) {
            // Hay restricciones de clave externa, no es posible eliminar el alumno
            header("Location: tablaAlumnos.php?error=El alumno no puede ser eliminado debido a restricciones de clave externa en otras_tablas.");
            exit();
        }

        // Si no hay restricciones de clave externa, procede a eliminar el alumno
        $sql = "DELETE FROM alumnos WHERE num_Control = '$num_Control'";
        $resultado = mysqli_query($link, $sql);

        if ($resultado) {
            header("Location: tablaAlumnos.php");
            exit();
        } else {
            echo "Error al eliminar al alumno: " . mysqli_error($link);
        }
    }
}
?>
