<?php
require_once 'conexion.php';

// Obtén la lista actualizada de alumnos
$alumnos_actualizados = obtenerAlumnos();

// Devuelve la tabla actualizada como HTML
echo '<tr>
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
    </tr>';

foreach ($alumnos_actualizados as $alumno) {
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
