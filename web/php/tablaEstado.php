<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Insertar y Editar Estado Civil</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Estados Civiles</h1>
    <!-- Formulario para insertar estado civil -->
    <form method="post" action="insertEstado.php" id="insertar-form">
        <label for="id_estado">ID del Estado Civíl (Un carácter máximo):</label>
        <input type="text" id="id_estado" name="id_estado" required maxlength="1">
        <label for="nombre_estado_edit">Nombre del Estado Civíl (Máximo 20 caracteres):</label>
        <input type="text" id="nombre_estado" name="nombre_estado" required required maxlength="20">
        <button type="submit">Insertar</button>
        <button type="button" onclick="limpiarCampos()">Cancelar</button>
    </form>


    <!-- Formulario para editar estado civil (inicialmente oculto) -->
    <form method="post" action="updateEstado.php" id="editar-form" style="display: none;">
    <label for="id_estado_edit">ID del Estado Civil</label>
    <input type="text" id="id_estado_edit" name="id_estado" readonly>
    <label for="nombre_estado_edit">Nombre del Estado Civíl (Máximo 20 caracteres):</label>
    <input type="text" id="nombre_estado_edit" name="nombre_estado" required maxlength="25">
    <button type="submit">Guardar</button>
    <button type="button" onclick="limpiarCampos()">Cancelar</button>
</form>



    <div id="error-message" class="error"></div>

    <?php
    if (isset($_GET['error'])) {
        echo '<div class="error">' . $_GET['error'] . '</div>';
    }
    ?>

    <!-- Mostrar la tabla de estado civil -->
    <table>
    <tr>
        <th>ID del Estado Civil</th>
        <th>Nombre del Estado Civil</th>
        <th>Acciones</th>
    </tr>
    <?php
    require 'conexion.php';
    $estados = obtenerEstados();
    foreach ($estados as $estado) {
        echo '<tr>';
        echo '<td>' . $estado['id_estado'] . '</td>';
        echo '<td>' . $estado['estadoCivil'] . '</td>';
        echo '<td>
                <a href="deleteEstado.php?id_estado=' . $estado['id_estado'] . '">Eliminar</a>
                <a href="javascript:editarEstado(\'' . $estado['id_estado'] . '\', \'' . $estado['estadoCivil'] . '\')">Seleccionar</a>
            </td>';
        echo '</tr>';
    }
    ?>
    </table>

    <!-- Formulario para ingresar un número manualmente -->
    <form method="post" action="javascript:cargarDatosManual()" id="manual-form">
        <label for="manual_id_estado">Editar Estado Civíl (Ingresa el ID)</label>
        <input type="text" id="manual_id_estado" name="manual_id_estado">
        <button type="button" onclick="cargarDatosManual()">Editar</button>
    </form>

    <!-- Formulario para eliminar un estado manualmente -->
    <form method="post" action="javascript:eliminarEstadoManual()" id="eliminar-manual-form">
        <label for="manual_id_estado_eliminar">Eliminar Estado Civíl (Ingresa el ID)</label>
        <input type="text" id="manual_id_estado_eliminar" name="manual_id_estado_eliminar">
        <button type="button" onclick="eliminarEstadoManual()">Eliminar</button>
    </form>

    <button type="button" onclick="window.location.href = 'indexAdmin.php'">Salir</button>


    <!-- Script para mostrar ventana de confirmación y eliminar Estado -->
    <script>
        function editarEstado(id, nombre) {
            // Llenar el formulario de edición con los datos del estado seleccionado
            document.getElementById('id_estado_edit').value = id;
            document.getElementById('nombre_estado_edit').value = nombre;

            // Ocultar el formulario de inserción y mostrar el formulario de edición
            document.getElementById('insertar-form').style.display = 'none';
            document.getElementById('editar-form').style.display = 'block';
        }

        function eliminarEstado(id, nombre) {
            // Mostrar una ventana emergente de confirmación
            var confirmar = confirm("¿Seguro que deseas eliminar el estado civíl con ID " + id + " (" + nombre + ")?");

            if (confirmar) {
                // Llenar el formulario de eliminación y enviarlo
                document.getElementById('manual_id_estado_eliminar').value = id;
                document.getElementById('eliminar-manual-form').submit();
            }
        }

        function limpiarCampos() {
            // Limpiar campos de ambos formularios
            document.getElementById('id_estado').value = '';
            document.getElementById('nombre_estado').value = '';
            document.getElementById('id_estado_edit').value = '';
            document.getElementById('nombre_estado_edit').value = '';

            // Ocultar el formulario de edición y mostrar el formulario de inserción
            document.getElementById('insertar-form').style.display = 'block';
            document.getElementById('editar-form').style.display = 'none';
            // Limpiar el mensaje de error
            document.getElementById('error-message').textContent = "";
        }

        function cargarDatosManual() {
            var manualId = document.getElementById('manual_id_estado').value;
            var estadoEncontrado = false;

            for (var i = 0; i < <?php echo count($estados); ?>; i++) {
                if (<?php echo json_encode($estados); ?>[i].id_estado === manualId) {
                    editarEstado(<?php echo json_encode($estados); ?>[i].id_estado, <?php echo json_encode($estados); ?>[i].estadoCivil);
                    estadoEncontrado = true;
                    break;
                }
            }

            if (!estadoEncontrado) {
                document.getElementById('error-message').textContent = "El ID ingresado no existe.";
            } else {
                document.getElementById('error-message').textContent = "";
            }
        }

        function eliminarEstadoManual() {
    var idAEliminar = document.getElementById('manual_id_estado_eliminar').value;
    var estadoAEliminar = null;

    for (var i = 0; i < <?php echo count($estados); ?>; i++) {
        if (<?php echo json_encode($estados); ?>[i].id_estado === idAEliminar) {
            estadoAEliminar = <?php echo json_encode($estados); ?>[i].estadoCivil;
            break;
        }
    }

    if (estadoAEliminar) {
        var confirmar = confirm("¿Seguro que deseas eliminar el estado '" + estadoAEliminar + "' con ID '" + idAEliminar + "'?");

        if (confirmar) {
            // Redirigir a la página de procesamiento de eliminación con el ID del estado
            window.location.href = "deleteEstado.php?id_estado=" + idAEliminar;
        }
    } else {
        alert("El ID ingresado no existe.");
    }
}
    </script>
</body>
</html>