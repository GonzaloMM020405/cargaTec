<?php
require 'conexion.php';
$generos = obtenerGeneros();
echo '<table>
    <tr>
        <th>ID de Género</th>
        <th>Nombre de Género</th>
        <th>Acciones</th>
    </tr>';
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
echo '</table>';
?>
