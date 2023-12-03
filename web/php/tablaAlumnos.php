<?php
// Incluye tu archivo de conexión
require_once 'conexion.php';

// Llama a las funciones para obtener los datos de las tablas
$estados = obtenerEstados();
$generos = obtenerGeneros();
$carreras = obtenerCarreras();
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>Insertar Alumnos</title>
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
    <h1>Alumnos</h1>
    <!-- Formulario para insertar alumnos -->
    <form method="post" action="tablaAlumnos.php">
        <label for="num_Control">Número de Control:</label>
        <input type="text" id="num_Control" name="num_Control" onchange="buscarNombreAlumnos()" required>
        
        <label for="nombre_a">Nombre:</label>
        <input type="text" id="nombre_a" name="nombre_a" required>
        
        <label for="paterno_a">Apellido Paterno:</label>
        <input type="text" id="paterno_a" name="paterno_a" required>
        
        <label for="materno_a">Apellido Materno:</label>
        <input type="text" id="materno_a" name="materno_a" required>
        
        <label for="correo_its">Correo ITS:</label>
        <input type="email" id="correo_its" name="correo_its" required>
        
        <label for="celular">Número de Celular:</label>
        <input type="tel" id="celular" name="celular" required>

        <!-- Combobox para id_estado -->
        <label for="id_estado">Estado Civil:</label>
        <select id="id_estado" name="id_estado" required>
            <?php
            foreach ($estados as $estado) {
                echo '<option value="' . $estado['id_estado'] . '">' . $estado['estadoCivil'] . '</option>';
            }
            ?>
        </select>

        <!-- Combobox para id_genero -->
        <label for="id_genero">Género:</label>
        <select id="id_genero" name="id_genero" required>
            <?php
            foreach ($generos as $genero) {
                echo '<option value="' . $genero['id_genero'] . '">' . $genero['genero'] . '</option>';
            }
            ?>
        </select>

        <!-- Combobox para id_carrera -->
        <label for="id_carrera">Carrera:</label>
        <select id="id_carrera" name="id_carrera" required>
            <?php
            foreach ($carreras as $carrera) {
                echo '<option value="' . $carrera['id_carrera'] . '">' . $carrera['nombre_c'] . '</option>';
            }
            ?>
        </select>

        <button type="button" id="insertar" onclick="validarCampos('insert')">Insertar</button>
        <button type="button" id="eliminar" onclick="validarCampos('eliminar')">Eliminar</button>
        <button type="button" id="actualizar" onclick="validarCampos('update')">Actualizar</button>
        <button type="button" onclick="limpiarCampos()">Cancelar</button>
    </form>

    <div class="error-message" id="error-message"></div>
    <div class="success-message" id="success-message"></div>

    <!-- Mostrar la tabla de alumnos -->
    <table>
        <tr>
            <th>Número de Control</th>
            <th>Nombre</th>
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>Correo ITS</th>
            <th>Número de Celular</th>
            <th>ID Estado Civil</th>
            <th>ID Género</th>
            <th>ID Carrera</th>
            <th>Acciones</th>
        </tr>
        <?php
        require_once 'conexion.php';  
        $alumnos = obtenerAlumnos();
        foreach ($alumnos as $alumno) {
            echo '<tr>';
            echo '<td>' . $alumno['num_Control'] . '</td>';
            echo '<td>' . $alumno['nombre_a'] . '</td>';
            echo '<td>' . $alumno['paterno_a'] . '</td>';
            echo '<td>' . $alumno['materno_a'] . '</td>';
            echo '<td>' . $alumno['correo_its'] . '</td>';
            echo '<td>' . $alumno['celular'] . '</td>';
            echo '<td>' . $alumno['id_estado'] . '</td>'; 
            echo '<td>' . $alumno['id_genero'] . '</td>'; 
            echo '<td>' . $alumno['id_carrera'] . '</td>';
            echo '<td>
                <a href="deleteAlumno.php?num_Control=' . $alumno['num_Control'] . '">Eliminar</a>
                <a href="javascript:seleccionarAlumno(\'' . $alumno['num_Control'] . '\', \'' . $alumno['nombre_a'] . '\', \'' . $alumno['paterno_a'] . '\', \'' . $alumno['materno_a'] . '\', \'' . $alumno['correo_its'] . '\', \'' . $alumno['celular'] . '\', \'' . $alumno['id_estado'] . '\', \'' . $alumno['id_genero'] . '\', \'' . $alumno['id_carrera'] . '\')">Seleccionar</a>
                </td>';
            echo '</tr>';
        }
        ?>
    </table>
    <div id="message"></div>
    <button type="button" onclick="window.location.href = 'indexAdmin.php'">Salir</button>
    <script>
         // Agregar eventos al cargar la página
            document.addEventListener('DOMContentLoaded', function () {
                // Asignar eventos a los botones
                document.getElementById("insertar").addEventListener("click", function () {
                    validarCampos('insert');
                });
                document.getElementById("eliminar").addEventListener("click", function () {
                    validarCampos('eliminar');
                });
                document.getElementById("actualizar").addEventListener("click", function () {
                    validarCampos('update');
                });
            });
        function limpiarCampos() {
            document.getElementById("num_Control").value = "";
            document.getElementById("nombre_a").value = "";
            document.getElementById("paterno_a").value = "";
            document.getElementById("materno_a").value = "";
            document.getElementById("correo_its").value = "";
            document.getElementById("celular").value = "";
            document.getElementById("id_estado").value = "";
            document.getElementById("id_genero").value = "";
            document.getElementById("id_carrera").value = "";
            document.getElementById("error-message").innerHTML = "";
            document.getElementById("success-message").innerHTML = "";
        }
        function validarCampos(accion) {
            var num_Control = document.getElementById("num_Control").value;
            var nombre_a = document.getElementById("nombre_a").value;
            var paterno_a = document.getElementById("paterno_a").value;
            var materno_a = document.getElementById("materno_a").value;
            var correo_its = document.getElementById("correo_its").value;
            var celular = document.getElementById("celular").value;
            var id_estado = document.getElementById("id_estado").value;
            var id_genero = document.getElementById("id_genero").value;
            var id_carrera = document.getElementById("id_carrera").value;

            if (num_Control === "" || nombre_a === "" || paterno_a === ""|| materno_a === ""|| celular === ""|| id_estado === ""|| id_genero === ""|| id_carrera === "") {
                alert("Ambos campos son obligatorios. Por favor, complete los campos vacíos.");
                return;
            }

            enviarFormulario(accion);
        }
        function enviarFormulario(accion) {

            var num_Control = document.getElementById("num_Control").value;
            var nombre_a = document.getElementById("nombre_a").value;
            var paterno_a = document.getElementById("paterno_a").value;
            var materno_a = document.getElementById("materno_a").value;
            var correo_its = document.getElementById("correo_its").value;
            var celular = document.getElementById("celular").value;
            var id_estado = document.getElementById("id_estado").value;
            var id_genero = document.getElementById("id_genero").value;
            var id_carrera = document.getElementById("id_carrera").value;
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

            xhr.open("POST", "gestionAlumnos.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("&num_Control=" + num_Control + "&nombre_a=" + nombre_a + "&paterno_a=" + paterno_a + "&materno_a=" + materno_a + "&correo_its=" + correo_its + "&celular=" + celular + "&id_estado=" + id_estado + "&id_genero=" + id_genero   + "&id_carrera=" + id_carrera + "&accion=" + accion);
        }

        function seleccionarAlumno(num_Control, nombre_a, paterno_a, materno_a, correo_its, celular, id_estado, id_genero, id_carrera) {
            document.getElementById("num_Control").value = num_Control;
            document.getElementById("nombre_a").value = nombre_a;
            document.getElementById("paterno_a").value = paterno_a;
            document.getElementById("materno_a").value = materno_a;
            document.getElementById("correo_its").value = correo_its;
            document.getElementById("celular").value = celular;
            document.getElementById("id_estado").value = id_estado;
            document.getElementById("id_genero").value = id_genero;
            document.getElementById("id_carrera").value = id_carrera;
        }

        function actualizarTabla() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.querySelector('table').innerHTML = xhr.responseText;
                }
            };

            xhr.open("GET", "actualizarTablaAlumnos.php", true);
            xhr.send();
        }

        function buscarNombreAlumnos() {
    var num_Control = document.getElementById("num_Control").value;
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = xhr.responseText;
            if (response.startsWith("Error")) {
                document.getElementById("error-message").innerHTML = response;
                document.getElementById("success-message").innerHTML = "";
            } else {
                document.getElementById("error-message").innerHTML = "";
                document.getElementById("success-message").innerHTML = "";

                // Parsear la respuesta JSON
                var datos = JSON.parse(response);

                // Rellenar los campos del formulario con los datos obtenidos
                document.getElementById("id_estado").value = datos.id_estado;
                document.getElementById("id_genero").value = datos.id_genero;
                document.getElementById("id_carrera").value = datos.id_carrera;
                document.getElementById("nombre_a").value = datos.nombre_a;
                document.getElementById("paterno_a").value = datos.paterno_a;
                document.getElementById("materno_a").value = datos.materno_a;
                document.getElementById("correo_its").value = datos.correo_its;
                document.getElementById("celular").value = datos.celular;
            }
        }
    };

    xhr.open("POST", "actualizarCampoAlumnos.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("num_Control=" + num_Control);
}
        // Llama a la función de actualización después de realizar una 
        // Por ejemplo, después de insertar, eliminar o actualizar un alumno
    </script>
</body>
</html>
