<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Insertar y Editar Estado Civíl</title>
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
    <h1>Estado Civíl</h1>
    <!-- Formulario para insertar estado -->
    <form method="post" action="gestionEstado.php">
        <label for="id_estado">ID del Estado Civíl (Un carácter máximo):</label>
        <input type="text" id="id_estado" name="id_estado" required maxlength="1" onchange="buscarNombreEstado()">
        <label for="nombre_estado">Nombre del Estado Civíl (Máximo 20 caracteres):</label>
        <input type="text" id="nombre_estado" name="nombre_estado" required maxlength="20">
        <button type="button" id="insertar" onclick="validarCampos('insert')">Insertar</button>
        <button type="submit" name="accion" value="eliminar">Eliminar</button>
        <button type="button" id="actualizar" onclick="enviarFormulario('update')">Actualizar</button>
        <button type="button" onclick="limpiarCampos()">Cancelar</button>
    </form>

    <div class="error-message" id="error-message"></div>
    <div class="success-message" id="success-message"></div>
    
    <?php
    if (isset($_GET['error'])) {
        echo '<div class="error">' . $_GET['error'] . '</div>';
    }
    ?>

    <!-- Mostrar la tabla de estado -->
    <table>
    <tr>
        <th>ID del Estado Civíl</th>
        <th>Nombre del Estado Civíl</th>
        <th>Acciones</th>
    </tr>
    <?php
    require 'conexion.php';
    $estados = obtenerEstadoS();
    foreach ($estados as $estado) {
        echo '<tr>';
        echo '<td>' . $estado['id_estado'] . '</td>';
        echo '<td>' . $estado['estadoCivil'] . '</td>';
        echo '<td>
                <a href="deleteEstado.php?id_estado=' . $estado['id_estado'] . '">Eliminar</a>
                <a href="javascript:seleccionarEstado(\'' . $estado['id_estado'] . '\', \'' . $estado['estadoCivil'] . '\')">Seleccionar</a>
            </td>';
        echo '</tr>';
    }
    ?>
    </table>
    <div id="message"></div>
    <button type="button" onclick="window.location.href = 'indexAdmin.php'">Salir</button>


    <script>
        
        function limpiarCampos() {
            document.getElementById("id_estado").value = "";
            document.getElementById("nombre_estado").value = "";
            document.getElementById("error-message").innerHTML = "";
            document.getElementById("success-message").innerHTML = "";
        }

        function validarCampos(accion) {
            var id_estado = document.getElementById("id_estado").value;
            var nombre_estado = document.getElementById("nombre_estado").value;

            if (id_estado === "" || nombre_estado === "") {
                alert("Ambos campos son obligatorios. Por favor, complete los campos vacíos.");
                return;
            }

            enviarFormulario(accion);
        }

        function enviarFormulario(accion) {
            var id_estado = document.getElementById("id_estado").value;
            var nombre_estado = document.getElementById("nombre_estado").value;

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

            xhr.open("POST", "gestionEstado.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("id_estado=" + id_estado + "&nombre_estado=" + nombre_estado + "&accion=" + accion);
        }

        function actualizarTabla() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.querySelector('table').innerHTML = xhr.responseText;
                }
            };

            xhr.open("GET", "actualizarTabla1.php", true);
            xhr.send();
        }
        function buscarNombreEstado() {
            var id_estado = document.getElementById("id_estado").value;
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = xhr.responseText;
                    if (response.startsWith("Error")) {
                        document.getElementById("error-message").innerHTML = response;
                        document.getElementById("success-message").innerHTML = "";
                        document.getElementById("nombre_estado").value = ""; // Limpia el campo en caso de error
                    } else {
                        document.getElementById("error-message").innerHTML = "";
                        document.getElementById("success-message").innerHTML = response;
                        document.getElementById("nombre_estado").value = response; // Llena el campo con el nombre del estado
                    }
                }
            };

            xhr.open("POST", "actualizarCampoEstado.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("id_estado=" + id_estado);
        }
        function seleccionarEstado(id, nombre) {
            // Obtener referencias a los campos del formulario
            var idEstadoInput = document.getElementById('id_estado');
            var nombreEstadoInput = document.getElementById('nombre_estado');

            // Establecer los valores en los campos del formulario
            idEstadoInput.value = id;
            nombreEstadoInput.value = nombre;
        }
    </script>
</body>
</html>
