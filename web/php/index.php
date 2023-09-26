<?php
    session_start();
    if(empty($_SESSION['usr'])){
        echo "Debe autentificarse";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>CargaTec</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
    </head>
    <body>
        <p>Bienvenido a CargaTec!</p>
        <script src="../js/script.js"></script>
    </body>
</html>
