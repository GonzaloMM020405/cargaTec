<?php
session_start(); //Inicia una sasion de PHP, se llama la inicio para asegurarse de que calquier informacion de sesion necesaria este disponivle antes de continuar con el resto del codigo

include_once 'conexion.php'; //Incluye el archivo de conexion a la base de datos. El archivo contiene las credenciales de acceso a la base de datos

if(isset($_POST["btnEnviar"])) //Comprueba si el botón de envío de formulario con el nombre btnEnviar ha sido presionado
{
    $_usr = $_POST['txtUsuario']; //Crea una variable de PHP llamada &_usr y asigna el valor del campo de texto del formulario con el nombre txtUsuario
    $_pwd = $_POST['txtPwd']; //Crea una variable de PHP llamada $_pwd y asigna el valor de lcampo de texto del formu;ario con el nombre "txtPwd"

    $strQry="select * from usuarios where
                usr= '".mysqli_real_escape_string($link,$_usr)."' and
                pwd= '".mysqli_real_escape_string($link,$_pwd)."'";
    //Crea una consulta SQL para buscar en la tabla de usuarios si hay una fila que coincida con el nombre de usuario y la contraseña proporcionados, el comando mysqli_real_escape_string se utiliza para evitar ataques de inyeccion de sql
    $coleccionRegistros = mysqli_query($link,$strQry); //ejecuta la consulta sql en la base de datos mediante la funcion mysqli_query y almacena los resultados en la variable coleccionregistros. La funcion mysqli_query() es una funcion de PHP que envia una consulta a una base de datos mysql con los parametros de la conexion y la consulta
    if(mysqli_num_rows($coleccionRegistros) >0) { //Comprueba que si se encontró la menos una fila que coincida con los datos proporcionados por el usuairo
    $registro = mysqli_fetch_array($coleccionRegistros); // La funcion mysqli_fetch_array(0 es utilizada para obtener la siguiente fila de un conjunto de datos como un array asociayuco, almacena el conjunto de resultados obtenido meduante la ejecucion de la consulta SQL en la linea anterior y con la funcion obtiene esa fila para almacenarla en la variable registroObtiene el primer registro de la coleccion de resultados t lo almacena en la variable registro
    $usr = $registro['usr']; //Crea una variable de PHP llamada $usr y asigna el valor del campo usr del registro obtenido
    $pwd = $registro['pwd']; //Crea una variable de PHP llamada $usr y asigna el valor del campo  usr del registro obtenido

    if($_usr == $usr and $_pwd == $pwd) //Comprueba si los datos proporcionados por el usuario coinciden con los datos almacenados en la base de datos
    {
        $_SESSION['usr'] = $usr; //si los dato son correctos, inicia una sesion de PHP y almacena el nombre de usuario en la variable de sesion usr
?>
        <script type='text/javascript'>
            window.location.href="index.php"; //Redirige al usuario a la pagina index.php usando js
        </script>

<?php
    }
}
    else //Si los datos son incorrectos, muestra un mensaje de error en la pantalla,
    {
        echo "Usuario y/o contraseña incorrectos"; //muestra un mensaje de error en pantalla si el inicio de sesion fallo
    }
}
?>
