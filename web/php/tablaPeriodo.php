<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Insertar y Editar Periodo</title>
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
    <h1>Periodo</h1>
    <!-- Formulario para insertar periodo -->
    <form method="post" action="gestionPeriodo.php">
        <label for="id_periodo">ID del Periodo (Un carácter máximo):</label>
        <input type="text" id="id_periodo" name="id_periodo" required maxlength="1" onchange="buscarNombrePeriodo()">
        <label for="nombre_periodo">Nombre del Periodo (Máximo 25 caracteres):</label>
        <input type="text" id="nombre_periodo" name="nombre_periodo" required maxlength="25">
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

    <!-- Mostrar la tabla de periodo -->
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
                <a href="javascript:seleccionarPeriodo(\'' . $periodo['id_periodo'] . '\', \'' . $periodo['periodo'] . '\')">Seleccionar</a>
            </td>';
        echo '</tr>';
    }
    ?>
    </table>
    <div id="message"></div>
    <button type="button" onclick="window.location.href = 'indexAdmin.php'">Salir</button>


    <script>
        
        function limpiarCampos() {
            document.getElementById("id_periodo").value = "";
            document.getElementById("nombre_periodo").value = "";
            document.getElementById("error-message").innerHTML = "";
            document.getElementById("success-message").innerHTML = "";
        }

        function validarCampos(accion) {
            var id_periodo = document.getElementById("id_periodo").value;
            var nombre_periodo = document.getElementById("nombre_periodo").value;

            if (id_periodo === "" || nombre_periodo === "") {
                alert("Ambos campos son obligatorios. Por favor, complete los campos vacíos.");
                return;
            }

            enviarFormulario(accion);
        }

        function enviarFormulario(accion) {
            var id_periodo = document.getElementById("id_periodo").value;
            var nombre_periodo = document.getElementById("nombre_periodo").value;

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

            xhr.open("POST", "gestionPeriodo.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("id_periodo=" + id_periodo + "&nombre_periodo=" + nombre_periodo + "&accion=" + accion);
        }

        function actualizarTabla() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.querySelector('table').innerHTML = xhr.responseText;
                }
            };

            xhr.open("GET", "actualizarTabla2.php", true);
            xhr.send();
        }
        function buscarNombrePeriodo() {
            var id_periodo = document.getElementById("id_periodo").value;
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = xhr.responseText;
                    if (response.startsWith("Error")) {
                        document.getElementById("error-message").innerHTML = response;
                        document.getElementById("success-message").innerHTML = "";
                        document.getElementById("nombre_periodo").value = ""; // Limpia el campo en caso de error
                    } else {
                        document.getElementById("error-message").innerHTML = "";
                        document.getElementById("success-message").innerHTML = response;
                        document.getElementById("nombre_periodo").value = response; // Llena el campo con el nombre del periodo
                    }
                }
            };

            xhr.open("POST", "actualizarCampoPeriodo.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("id_periodo=" + id_periodo);
        }
        function seleccionarPeriodo(id, nombre) {
            // Obtener referencias a los campos del formulario
            var idPeriodoInput = document.getElementById('id_periodo');
            var nombrePeriodoInput = document.getElementById('nombre_periodo');

            // Establecer los valores en los campos del formulario
            idPeriodoInput.value = id;
            nombrePeriodoInput.value = nombre;
        }
    </script>
</body>
</html>