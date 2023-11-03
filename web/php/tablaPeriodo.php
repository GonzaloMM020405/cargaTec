<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Insertar y Editar Periodo</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Periodos</h1>
    <!-- Formulario para insertar periodo -->
    <form method="post" action="insertPeriodo.php" id="insertar-form">
        <label for="id_periodo">ID del Periodo (Un carácter máximo):</label>
        <input type="text" id="id_periodo" name="id_periodo" required maxlength="1">
        <label for="nombre_periodo_edit">Nombre del Periodo (Máximo 25 caracteres de esta manera: MesInicio-MesFin Año):</label>
        <input type="text" id="nombre_periodo" name="nombre_periodo" required required maxlength="25">
        <button type="submit">Insertar</button>
        <button type="button" onclick="limpiarCampos()">Cancelar</button>
    </form>


    <!-- Formulario para editar periodo (inicialmente oculto) -->
    <form method="post" action="updatePeriodo.php" id="editar-form" style="display: none;">
    <label for="id_periodo_edit">ID del Periodo</label>
    <input type="text" id="id_periodo_edit" name="id_periodo" readonly>
    <label for="nombre_periodo_edit">Nombre del Periodo (Máximo 25 caracteres de esta manera: MesInicio-MesFin Año):</label>
    <input type="text" id="nombre_periodo_edit" name="nombre_periodo" required maxlength="25">
    <button type="submit">Guardar</button>
    <button type="button" onclick="limpiarCampos()">Cancelar</button>
</form>



    <div id="error-message" class="error"></div>

    <?php
    if (isset($_GET['error'])) {
        echo '<div class="error">' . $_GET['error'] . '</div>';
    }
    ?>

    <!-- Mostrar la tabla de periodos -->
    <table>
    <tr>
        <th>ID del Periodo</th>
        <th>Nombre del Periodo</th>
        <th>Acciones</th>
    </tr>
    <?php
    require 'conexion.php';
    $periodos = obtenerPeriodos();
    foreach ($periodos as $periodo) {
        echo '<tr>';
        echo '<td>' . $periodo['id_periodo'] . '</td>';
        echo '<td>' . $periodo['periodo'] . '</td>';
        echo '<td>
                <a href="deletePeriodo.php?id_periodo=' . $periodo['id_periodo'] . '">Eliminar</a>
                <a href="javascript:editarPeriodo(\'' . $periodo['id_periodo'] . '\', \'' . $periodo['periodo'] . '\')">Seleccionar</a>
            </td>';
        echo '</tr>';
    }
    ?>
    </table>

    <!-- Formulario para ingresar un número manualmente -->
    <form method="post" action="javascript:cargarDatosManual()" id="manual-form">
        <label for="manual_id_periodo">Editar Periodo (Ingresa el ID)</label>
        <input type="text" id="manual_id_periodo" name="manual_id_periodo">
        <button type="button" onclick="cargarDatosManual()">Editar</button>
    </form>

    <!-- Formulario para eliminar un periodo manualmente -->
    <form method="post" action="javascript:eliminarPeriodoManual()" id="eliminar-manual-form">
        <label for="manual_id_periodo_eliminar">Eliminar Periodo (Ingresa el ID)</label>
        <input type="text" id="manual_id_periodo_eliminar" name="manual_id_periodo_eliminar">
        <button type="button" onclick="eliminarPeriodoManual()">Eliminar</button>
    </form>

    <button type="button" onclick="window.location.href = 'indexAdmin.php'">Salir</button>


    <!-- Script para mostrar ventana de confirmación y eliminar periodo -->
    <script>
        function editarPeriodo(id, nombre) {
            // Llenar el formulario de edición con los datos del periodo seleccionado
            document.getElementById('id_periodo_edit').value = id;
            document.getElementById('nombre_periodo_edit').value = nombre;

            // Ocultar el formulario de inserción y mostrar el formulario de edición
            document.getElementById('insertar-form').style.display = 'none';
            document.getElementById('editar-form').style.display = 'block';
        }

        function eliminarGenero(id, nombre) {
            // Mostrar una ventana emergente de confirmación
            var confirmar = confirm("¿Seguro que deseas eliminar el periodo con ID " + id + " (" + nombre + ")?");

            if (confirmar) {
                // Llenar el formulario de eliminación y enviarlo
                document.getElementById('manual_id_periodo_eliminar').value = id;
                document.getElementById('eliminar-manual-form').submit();
            }
        }

        function limpiarCampos() {
            // Limpiar campos de ambos formularios
            document.getElementById('id_periodo').value = '';
            document.getElementById('nombre_periodo').value = '';
            document.getElementById('id_periodo_edit').value = '';
            document.getElementById('nombre_periodo_edit').value = '';

            // Ocultar el formulario de edición y mostrar el formulario de inserción
            document.getElementById('insertar-form').style.display = 'block';
            document.getElementById('editar-form').style.display = 'none';
            // Limpiar el mensaje de error
            document.getElementById('error-message').textContent = "";
        }

        function cargarDatosManual() {
            var manualId = document.getElementById('manual_id_periodo').value;
            var periodoEncontrado = false;

            for (var i = 0; i < <?php echo count($periodos); ?>; i++) {
                if (<?php echo json_encode($periodos); ?>[i].id_periodo === manualId) {
                    editarPeriodo(<?php echo json_encode($periodos); ?>[i].id_periodo, <?php echo json_encode($periodos); ?>[i].periodo);
                    periodoEncontrado = true;
                    break;
                }
            }

            if (!periodoEncontrado) {
                document.getElementById('error-message').textContent = "El ID ingresado no existe.";
            } else {
                document.getElementById('error-message').textContent = "";
            }
        }

        function eliminarPeriodoManual() {
    var idAEliminar = document.getElementById('manual_id_periodo_eliminar').value;
    var periodoAEliminar = null;

    for (var i = 0; i < <?php echo count($periodos); ?>; i++) {
        if (<?php echo json_encode($periodos); ?>[i].id_periodo === idAEliminar) {
            periodoAEliminar = <?php echo json_encode($periodos); ?>[i].periodo;
            break;
        }
    }

    if (periodoAEliminar) {
        var confirmar = confirm("¿Seguro que deseas eliminar el periodo '" + periodoAEliminar + "' con ID '" + idAEliminar + "'?");

        if (confirmar) {
            // Redirigir a la página de procesamiento de eliminación con el ID del periodo
            window.location.href = "deletePeriodo.php?id_periodo=" + idAEliminar;
        }
    } else {
        alert("El ID ingresado no existe.");
    }
}
    </script>
</body>
</html>