<?php
    $host   = "localhost"; //se define la variable host con el nombre del servidor de la base de datos, en este caso localhost
    $dbuser = "root"; //se define la variable $dbuser con el nombre del usuario de la base de datos que se utilizara para conectarse
    $dbpass = ""; //se defina la variable $dbpass con la contraseña del usuairo de la base de datos que se utilizará para conectarse, en este caso root
    $db     = "cargatec"; //se define la variable $db con el nombre de la base de datos que se va a utilizar

    $link   = mysqli_connect($host,$dbuser,$dbpass,$db); //se establece la conexion con la base de datos utilizando la funcion mysqli_connect() que recibe como paramentros l nombre del servidor, el usuario, la contraseña y el nombre de la base de datos y se almacena en la variable link
    //print_r($link);
    if(mysqli_connect_error()){ //verifica si la conexion a la base de datos ha generado algun error, si es asi se muestra una alerta indicando que no se puede conectar a la base de datos
        echo "<script>alert('No se pudo conectar con la base de datos.');</script>";
    }


    

    mysqli_select_db($link, 'cargatec') or die('No se puede abrir la estructura de BD'.mysqli_connect_error()); //seleccioa la base de datos 'usuariosbd'para que las consultas posteriores se realicen en esta base de datosy ejecuta el texto en caso de error
    function obtenerMateriasDisponibles() {
        global $link;
        $num_Control = $_SESSION['nombre_usuario'];
        $query_carrera = "SELECT id_carrera FROM alumnos WHERE num_Control = '$num_Control'";
        $result_carrera = mysqli_query($link, $query_carrera);
        $row_carrera = mysqli_fetch_assoc($result_carrera);
        $id_carrera_alumno = $row_carrera['id_carrera'];
    
        $query = "SELECT m.*, c.nombre_c AS nombre_carrera, ma.nombre_m, ma.paterno_m, ma.materno_m, p.periodo, mat.nombre_mat
                  FROM muestreo m
                  JOIN carrera c ON m.id_carrera = c.id_carrera
                  JOIN materia mat ON m.id_materia = mat.id_materia
                  LEFT JOIN maestros ma ON m.id_maestro = ma.id_maestro
                  JOIN periodo p ON m.id_periodo = p.id_periodo
                  WHERE m.id_carrera = $id_carrera_alumno";
    
        $result = mysqli_query($link, $query);
    
        $materias = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $materias[] = $row;
        }
    
        return $materias;
    }
    
    function obtenerCarga(){
        global $link;
        $num_Control = $_SESSION['nombre_usuario'];
        

        $query = "SELECT c.*, m.*, ca.nombre_c AS nombre_carrera, ma.nombre_m, ma.paterno_m, ma.materno_m, p.periodo, mat.nombre_mat 
          FROM carga c 
          JOIN muestreo m ON c.id_materia = m.id_materia 
          JOIN materia mat ON m.id_materia = mat.id_materia
          JOIN carrera ca ON m.id_carrera = ca.id_carrera
          JOIN maestros ma ON m.id_maestro = ma.id_maestro
          JOIN periodo p ON m.id_periodo = p.id_periodo 
        WHERE c.num_Control = '$num_Control'";
                        

    $result = mysqli_query($link, $query);
    $carga = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $carga[] = $row;
        }
    
        return $carga;
    }

    function obtenerAlumnos() {
        global $link;
    
        $query = "SELECT * FROM alumnos"; 
        $result = mysqli_query($link, $query);
    
        $alumnos = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $alumnos[] = $row;
        }
    
        return $alumnos;
    }
       
    function obtenerGeneros() {
        global $link;
    
        $query = "SELECT id_genero, genero FROM generos";
        $result = mysqli_query($link, $query);
    
        $generos = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $generos[] = $row;
        }
    
        return $generos;
    }
    function obtenerPeriodos() {
        global $link;

        $query = "SELECT id_periodo, periodo FROM periodo";
        $result = mysqli_query($link, $query);

        $periodos = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $periodos[] = $row;
        }

        return $periodos;
    }
    function obtenerEstados() {
        global $link;

        $query = "SELECT id_estado, estadoCivil FROM estadocivil";
        $result = mysqli_query($link, $query);

        $estados = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $estados[] = $row;
        }

        return $estados;
    }
    function obtenerCarreras() {
        global $link;
    
        $query = "SELECT id_carrera, nombre_c FROM carrera";
        $result = mysqli_query($link, $query);
    
        $carreras = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $carreras[] = $row;
        }
    
        return $carreras;
    }
?>