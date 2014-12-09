
<html>
    <head>
        <meta charset="UTF-8">
        <title>Adminstracion de alumnos</title>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
    </head>
    <body>
        <?php
//var_dump($_REQUEST);
//die();
        require_once 'includes/funciones.php';
        $documento = limpiaString($_REQUEST['documento']);
        $apellido = limpiaString($_REQUEST['apellido']);
        $carrera = limpiaString($_REQUEST['carrera']);
        $sede = limpiaString($_REQUEST['sede']);
        if (empty($documento) and empty($apellido)) {
            echo '<div class="alert alert-danger" role="alert">Debe ingresar algun valor para buscar..</div>';
            die();
        }
         $sql ="    SELECT
                `alumnos`.`Id`
                , `alumnos`.`Apellido`
                , `alumnos`.`Nombre`
                , `documento`.`nombre`
                , `alumnos`.`NroDocumento`
                 , DATE_FORMAT(`alumnos`.`FechaNacimiento`,'%d.%m.%Y')
                 , alumnos.titulo
                 , alumnos.apto_fisico
                FROM
                `alumnos`
                INNER JOIN `asignacion` 
                    ON (`alumnos`.`Id` = `asignacion`.`idpostulante`)
                INNER JOIN `documento` 
                    ON (`documento`.`id` = `alumnos`.`TipoDocumento`)
                     where alumnos.id > 0  
                    ";

        
        if (isset($documento) and ! empty($documento)) {
            $sql = $sql . "and nrodocumento ='$documento'";
        }

        if (isset($apellido) and ! empty($apellido)) {
            $sql = $sql . "and apellido like '%$apellido%'";
        }
        if (isset($carrera) and $carrera<>0) {
            $sql = $sql . "and asignacion.idespecialidad = '$carrera'";
        }
        if (isset($sede) and $sede<>0) {
            $sql = $sql . "and asignacion.idhospital = '$sede'";
        }
//      

//        echo $sql;
        $proxy = conectar();
        if ($result = $proxy->query($sql)) {

            echo '<p><a href="#">Resultado de la busqueda <span class="badge">' . $result->num_rows . ' alumno/s</span></a></p>';

            echo '<table class="table table-striped">';
            echo '<thead><h4><td>Nombre</td><td>Apellido</td><td>Tipo y Nro de Doc.</td><td>Fecha Nac.</td><td>Documentación</td><td></td></h4></thead>';
            echo '<tbody>';
            while ($row = $result->fetch_array()) {
               $boton = '        <!-- Extra small button group -->
                    <div class="btn-group">
                        <button class="btn btn-default btn-xs dropdown-toggle" type="button" 
                        data-toggle="dropdown" aria-expanded="false">
                            Acciones <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="alumnos.php?id='.$row[0].'">Modificar</a></li>
                            <li><a href="carga_documentacion.php?id='.$row[0].'">Documentación</a></li>
                        </ul>
                    </div>';
                if($row[6]=='1' and $row[7]=='1'){
                    $doc = '<img src="imagenes/semaforoverde.jpg" alt="" height="20" width="20"> ';
                } else{
                    $doc = '<img src="imagenes/semafororojo.gif" alt="" height="20" width="20"> ';
                }
                echo'<tr><td>' . utf8_encode($row[2]) . '</td><td>' . utf8_decode($row[1]) . '</td><td>' . $row[3] . ' ' . $row[4] . '</td><td>' . $row[5] . '</td><td>'.$doc.'</td><td>' . $boton . '</td></tr>';
            }
            echo '</tbody></table>';
        }
        ?>




    </body>

     
</html>
    <!--<script>
        $('.dropdown-toggle').dropdown()
    </script>-->