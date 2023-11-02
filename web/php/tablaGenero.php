<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Insertar y Editar Género</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Géneros</h1>
    <!-- Formulario para insertar género -->
    <form method="post" action="insertGenero.php" id="insertar-form">
        <label for="id_genero">ID del Género (Un carácter máximo):</label>
        <input type="text" id="id_genero" name="id_genero" required maxlength="1">
        <label for="nombre_genero_edit">Nombre del Género (Máximo 20 caracteres):</label>
        <input type="text" id="nombre_genero" name="nombre_genero" required required maxlength="20">
        <button type="submit">Insertar</button>
        <button type="button" onclick="limpiarCampos()">Cancelar</button>
    </form>


    <!-- Formulario para editar género (inicialmente oculto) -->
    <form method="post" action="updateGenero.php" id="editar-form" style="display: none;">
    <label for="id_genero_edit">ID del Género:</label>
    <input type="text" id="id_genero_edit" name="id_genero" readonly>
    <label for="nombre_genero_edit">Nombre del Género (Máximo 20 caracteres):</label>
    <input type="text" id="nombre_genero_edit" name="nombre_genero" required maxlength="20">
    <button type="submit">Guardar</button>
    <button type="button" onclick="limpiarCampos()">Cancelar</button>
</form>



    <div id="error-message" class="error"></div>

    <?php
    if (isset($_GET['error'])) {
        echo '<div class="error">' . $_GET['error'] . '</div>';
    }
    ?>

    <!-- Mostrar la tabla de géneros -->
    <table>
    <tr>
        <th>ID del Género</th>
        <th>Nombre del Género</th>
        <th>Acciones</th>
    </tr>
    <?php
    require 'conexion.php';
    $generos = obtenerGeneros();
    foreach ($generos as $genero) {
        echo '<tr>';
        echo '<td>' . $genero['id_genero'] . '</td>';
        echo '<td>' . $genero['genero'] . '</td>';
        echo '<td>
                <a href="deleteGenero.php?id_genero=' . $genero['id_genero'] . '">Eliminar</a>
                <a href="javascript:editarGenero(\'' . $genero['id_genero'] . '\', \'' . $genero['genero'] . '\')">Seleccionar</a>
            </td>';
        echo '</tr>';
    }
    ?>
    </table>

    <!-- Formulario para ingresar un número manualmente -->
    <form method="post" action="javascript:cargarDatosManual()" id="manual-form">
        <label for="manual_id_genero">Editar Género (Ingresa el ID)</label>
        <input type="text" id="manual_id_genero" name="manual_id_genero">
        <button type="button" onclick="cargarDatosManual()">Editar</button>
    </form>

    <!-- Formulario para eliminar un género manualmente -->
    <form method="post" action="javascript:eliminarGeneroManual()" id="eliminar-manual-form">
        <label for="manual_id_genero_eliminar">Eliminar Género (Ingresa el ID)</label>
        <input type="text" id="manual_id_genero_eliminar" name="manual_id_genero_eliminar">
        <button type="button" onclick="eliminarGeneroManual()">Eliminar</button>
    </form>

    <button type="button" onclick="window.location.href = 'indexAdmin.php'">Salir</button>


    <!-- Script para mostrar ventana de confirmación y eliminar género -->
    <script>
        function editarGenero(id, nombre) {
            // Llenar el formulario de edición con los datos del género seleccionado
            document.getElementById('id_genero_edit').value = id;
            document.getElementById('nombre_genero_edit').value = nombre;

            // Ocultar el formulario de inserción y mostrar el formulario de edición
            document.getElementById('insertar-form').style.display = 'none';
            document.getElementById('editar-form').style.display = 'block';
        }

        function eliminarGenero(id, nombre) {
            // Mostrar una ventana emergente de confirmación
            var confirmar = confirm("¿Seguro que deseas eliminar el género con ID " + id + " (" + nombre + ")?");

            if (confirmar) {
                // Llenar el formulario de eliminación y enviarlo
                document.getElementById('manual_id_genero_eliminar').value = id;
                document.getElementById('eliminar-manual-form').submit();
            }
        }

        function limpiarCampos() {
            // Limpiar campos de ambos formularios
            document.getElementById('id_genero').value = '';
            document.getElementById('nombre_genero').value = '';
            document.getElementById('id_genero_edit').value = '';
            document.getElementById('nombre_genero_edit').value = '';

            // Ocultar el formulario de edición y mostrar el formulario de inserción
            document.getElementById('insertar-form').style.display = 'block';
            document.getElementById('editar-form').style.display = 'none';
            // Limpiar el mensaje de error
            document.getElementById('error-message').textContent = "";
        }

        function cargarDatosManual() {
            var manualId = document.getElementById('manual_id_genero').value;
            var generoEncontrado = false;

            for (var i = 0; i < <?php echo count($generos); ?>; i++) {
                if (<?php echo json_encode($generos); ?>[i].id_genero === manualId) {
                    editarGenero(<?php echo json_encode($generos); ?>[i].id_genero, <?php echo json_encode($generos); ?>[i].genero);
                    generoEncontrado = true;
                    break;
                }
            }

            if (!generoEncontrado) {
                document.getElementById('error-message').textContent = "El ID ingresado no existe.";
            } else {
                document.getElementById('error-message').textContent = "";
            }
        }

        function eliminarGeneroManual() {
    var idAEliminar = document.getElementById('manual_id_genero_eliminar').value;
    var generoAEliminar = null;

    for (var i = 0; i < <?php echo count($generos); ?>; i++) {
        if (<?php echo json_encode($generos); ?>[i].id_genero === idAEliminar) {
            generoAEliminar = <?php echo json_encode($generos); ?>[i].genero;
            break;
        }
    }

    if (generoAEliminar) {
        var confirmar = confirm("¿Seguro que deseas eliminar el género '" + generoAEliminar + "' con ID '" + idAEliminar + "'?");

        if (confirmar) {
            // Redirigir a la página de procesamiento de eliminación con el ID del género
            window.location.href = "deleteGenero.php?id_genero=" + idAEliminar;
        }
    } else {
        alert("El ID ingresado no existe.");
    }
}
    </script>
</body>
</html>
