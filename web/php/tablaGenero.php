<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Insertar y Editar Género</title>
    <style>
        .error-message {
            color: red;
        }
        .success-message {
            color: green;
        }
    </style>
</head>
<body>
    <h1>Géneros</h1>
    <!-- Formulario para insertar género -->
    <form method="post" action="gestionGenero.php">
        <label for="id_genero">ID del Género (Un carácter máximo):</label>
        <input type="text" id="id_genero" name="id_genero" required maxlength="1" onchange="buscarNombreGenero()">
        <label for="nombre_genero">Nombre del Género (Máximo 20 caracteres):</label>
        <input type="text" id="nombre_genero" name="nombre_genero" required maxlength="20">
        <button type="submit" id="insertar" onclick="validarCampos('insert')">Insertar</button>
        <button type="submit" name="accion" value="eliminar">Eliminar</button>
        <button type="submit" id="actualizar" onclick="enviarFormulario('update')">Actualizar</button>
        <button type="button" onclick="limpiarCampos()">Cancelar</button>
    </form>

    <div class="error-message" id="error-message"></div>
    <div class="success-message" id="success-message"></div>
    
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
                <a href="javascript:seleccionarGenero(\'' . $genero['id_genero'] . '\', \'' . $genero['genero'] . '\')">Seleccionar</a>
            </td>';
        echo '</tr>';
    }
    ?>
    </table>
    <div id="message"></div>
    <button type="button" onclick="window.location.href = 'indexAdmin.php'">Salir</button>


    <script>
        
        function limpiarCampos() {
            document.getElementById("id_genero").value = "";
            document.getElementById("nombre_genero").value = "";
            document.getElementById("error-message").innerHTML = "";
            document.getElementById("success-message").innerHTML = "";
        }

        function validarCampos(accion) {
            var id_genero = document.getElementById("id_genero").value;
            var nombre_genero = document.getElementById("nombre_genero").value;

            if (id_genero === "" || nombre_genero === "") {
                alert("Ambos campos son obligatorios. Por favor, complete los campos vacíos.");
                return;
            }

            enviarFormulario(accion);
        }

        function enviarFormulario(accion) {
            var id_genero = document.getElementById("id_genero").value;
            var nombre_genero = document.getElementById("nombre_genero").value;

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = xhr.responseText;
                    if (response.startsWith("Error")) {
                        document.getElementById("error-message").innerHTML = response;
                        document.getElementById("success-message").innerHTML = "";
                    } else {
                        document.getElementById("success-message").innerHTML = response;
                        document.getElementById("error-message").innerHTML = "";
                        // Actualizar la tabla
                        actualizarTabla();
                    }
                }
            };

            xhr.open("POST", "gestionGenero.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("id_genero=" + id_genero + "&nombre_genero=" + nombre_genero + "&accion=" + accion);
        }

        function actualizarTabla() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.querySelector('table').innerHTML = xhr.responseText;
                }
            };

            xhr.open("GET", "actualizarTabla.php", true);
            xhr.send();
        }
        function buscarNombreGenero() {
            var id_genero = document.getElementById("id_genero").value;
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = xhr.responseText;
                    if (response.startsWith("Error")) {
                        document.getElementById("error-message").innerHTML = response;
                        document.getElementById("success-message").innerHTML = "";
                        document.getElementById("nombre_genero").value = ""; // Limpia el campo en caso de error
                    } else {
                        document.getElementById("error-message").innerHTML = "";
                        document.getElementById("success-message").innerHTML = response;
                        document.getElementById("nombre_genero").value = response; // Llena el campo con el nombre del género
                    }
                }
            };

            xhr.open("POST", "actualizarCampoGenero.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("id_genero=" + id_genero);
        }
        function seleccionarGenero(id, nombre) {
            // Obtener referencias a los campos del formulario
            var idGeneroInput = document.getElementById('id_genero');
            var nombreGeneroInput = document.getElementById('nombre_genero');

            // Establecer los valores en los campos del formulario
            idGeneroInput.value = id;
            nombreGeneroInput.value = nombre;
        }
    </script>
</body>
</html>
