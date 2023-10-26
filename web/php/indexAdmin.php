<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Insertar Género</title>
</head>
<body>
    <h1>Insertar Género</h1>
    <form method="post" action="tablaGenero.php">
        <label for="id_genero">ID del Género:</label>
        <input type="text" id="id_genero" name="id_genero" required>
        <label for="nombre_genero">Nombre del Género:</label>
        <input type="text" id="nombre_genero" name="nombre_genero" required>
        <button type="submit">Insertar</button>
    </form>
</body>
</html>
