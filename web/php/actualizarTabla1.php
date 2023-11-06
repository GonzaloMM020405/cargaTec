<?php
require 'conexion.php';
$estados = obtenerEstados();
echo '<table>
    <tr>
        <th>ID deL Estado Civil</th>
        <th>Nombre de Estado Civil</th>
        <th>Acciones</th>
    </tr>';
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
echo '</table>';
?>