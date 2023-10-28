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
    <form method="post" action="tablaGenero.php" id="insertar-form">
        <label for="id_genero">ID del Género:</label>
        <input type="text" id="id_genero" name="id_genero" required>
        <label for="nombre_genero">Nombre del Género:</label>
        <input type="text" id="nombre_genero" name="nombre_genero" required>
        <button type="submit">Insertar</button>
        <button type="button" onclick="limpiarCampos()">Cancelar</button>
    </form>

    <!-- Formulario para editar género (inicialmente oculto) -->
    <form method="post" action="procesarEdicionGenero.php" id="editar-form" style="display: none;">
        <label for="id_genero_edit">ID del Género:</label>
        <input type="text" id="id_genero_edit" name="id_genero" readonly>
        <label for="nombre_genero_edit">Nombre del Género:</label>
        <input type="text" id="nombre_genero_edit" name="nombre_genero" required>
        <button type="submit">Guardar</button>
        <button type="button" onclick="limpiarCampos()">Cancelar</button>
    </form>

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
                <a href="eliminarGenero.php?id=' . $genero['id_genero'] . '">Eliminar</a>
                <a href="javascript:editarGenero(\'' . $genero['id_genero'] . '\', \'' . $genero['genero'] . '\')">Editar</a>
            </td>';
        echo '</tr>';
    }
    ?>
</table>

<script>
function editarGenero(id, nombre) {
    // Llenar el formulario de edición con los datos del género seleccionado
    document.getElementById('id_genero_edit').value = id;
    document.getElementById('nombre_genero_edit').value = nombre;

    // Ocultar el formulario de inserción y mostrar el formulario de edición
    document.getElementById('insertar-form').style.display = 'none';
    document.getElementById('editar-form').style.display = 'block';
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
}
</script>
</body>
</html>
