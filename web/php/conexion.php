<?php

$host   = "localhost"; //se define la variable host con el nombre del servidor de la base de datos, en este caso localhost
$dbuser = "admincargatec"; //se define la variable $dbuser con el nombre del usuario de la base de datos que se utilizara para conectarse
$dbpass = ""; //se defina la variable $dbpass con la contraseña del usuairo de la base de datos que se utilizará para conectarse, en este caso root
$db     = "cargatec"; //se define la variable $db con el nombre de la base de datos que se va a utilizar

$link   = mysqli_connect($host,$dbuser,$dbpass,$db); //se establece la conexion con la base de datos utilizando la funcion mysqli_connect() que recibe como paramentros l nombre del servidor, el usuario, la contraseña y el nombre de la base de datos y se almacena en la variable link
//print_r($link);
if(mysqli_connect_error()){ //verifica si la conexion a la base de datos ha generado algun error, si es asi se muestra una alerta indicando que no se puede conectar a la base de datos
    echo "<script>alert('No se pudo conectar con la base de datos.');</script>";
}

mysqli_select_db($link, 'cargatec') or die('No se puede abrir la estrctura de BD'.mysqli_connect_error()); //seleccioa la base de datos 'usuariosbd'para que las consultas posteriores se realicen en esta base de datosy ejecuta el texto en caso de error
?>