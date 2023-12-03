<?php
require 'conexion.php';
$periodos = obtenerPeriodos();
echo '<table>
    <tr>
        <th>ID de Periodo</th>
        <th>Nombre de Periodo</th>
        <th>Acciones</th>
    </tr>';
foreach ($periodos as $periodo) {
    echo '<tr>';
    echo '<td>' . $periodo['id_periodo'] . '</td>';
    echo '<td>' . $periodo['periodo'] . '</td>';
    echo '<td>
            <a href="deletePeriodo.php?id_periodo=' . $periodo['id_periodo'] . '">Eliminar</a>
            <a href="javascript:editarPeriodo(\'' . $periodo['id_periodo'] . '\', \'' . $periodo['periodo'] . '\')">Seleccionar</a>
        </td>';
    echo '</tr>';
}
echo '</table>';
?>