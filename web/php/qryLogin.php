<?php
session_start(); //Inicia una sasion de PHP, se llama la inicio para asegurarse de que calquier informacion de sesion necesaria este disponivle antes de continuar con el resto del codigo

include_once 'conexion.php'; //Incluye el archivo de conexion a la base de datos. El archivo contiene las credenciales de acceso a la base de datos

if(isset($_POST["btnEnviar"])) {
    $_usr = $_POST['txtUsuario'];
    $_pwd = $_POST['txtPwd'];

    $strQry = "SELECT * FROM usuarios WHERE usr = '" . mysqli_real_escape_string($link, $_usr) . "' AND pwd = '" . mysqli_real_escape_string($link, $_pwd) . "'";
    $coleccionRegistros = mysqli_query($link, $strQry);

    if(mysqli_num_rows($coleccionRegistros) > 0) {
        $registro = mysqli_fetch_array($coleccionRegistros);
        $usr = $registro['usr'];
        $pwd = $registro['pwd'];
        $tipoUsuario = $registro['tipo']; // Agrega la columna 'tipo_usuario' de la tabla 'usuarios'

        if ($_usr == $usr && $_pwd == $pwd) {
            if ($tipoUsuario == 0) {
                $_SESSION['num_Control'] = true;
                $_SESSION['tipo'] = 0; // Administrador
                ?>
                <script type='text/javascript'>
                     window.location.href="indexAdmin.php"; //Redirige al usuario a la pagina index.php usando js
                </script>
<?php
            exit();
} elseif ($tipoUsuario == 1) {
    $_SESSION['nombre_usuario'] = $usr; // Establece la variable de sesión 'nombre_usuario'
    $_SESSION['tipo'] = 1; // Alumno
            ?>
                <script type='text/javascript'>
                     window.location.href="carga.php"; //Redirige al usuario a la pagina index.php usando js
                </script>
        <?php
            exit();
            } else {
                echo "Tipo de usuario no válido";
            }
        }
    } else {
        echo "Usuario y/o contraseña incorrectos";
    }
}

?>
