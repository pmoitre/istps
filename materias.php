<?php
require_once 'includes/iniciar_sesion.php';
require_once 'includes/funciones.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div style="width: 15%;float: left">
            <ul class="nav nav-pills nav-stacked">
                <li role="presentation" ><a href="curricula.php">Curricula</a></li>
                <li role="presentation" class="active"><a href="#">Materias</a></li>

            </ul>
        </div>

        <?php
        if (!isset($_REQUEST['curricula'])) {
            die();
        }
        echo '<div align="left"><div align="left" class="btn-group" role="group" aria-label="...">
            <button type="button" class="btn btn-default">Nuevo</button>
            
          </div></div>';
        $curricula = limpiaString($_REQUEST['curricula']);
        $sql = "SELECT
                    `materia`.`id`
                    , `materia`.`nombre`
                    , `docente`.`id` AS `iddocente`
                    , `docente`.`nombre`
                    , `docente`.`apellido`
                FROM
                    `docente`
                    INNER JOIN `materia_docente` 
                        ON (`docente`.`id` = `materia_docente`.`id_docente`)
                    RIGHT JOIN `materia` 
                        ON (`materia`.`id` = `materia_docente`.id_materia) 
                WHERE (`materia`.`idcurricula` ='$curricula' )";
        
        $conex = conectar();

        if ($result = $conex->query($sql)) {
            echo '<div style="width:75%;float:left"><table class="table table-striped">';
            echo '<thead><h4><td>Nombre</td><td>Docente a cargo</td><td></td></h4></thead>';
            echo '<tbody>';
            while ($row = $result->fetch_array()) {
                                
                $boton = '  <div class="btn-group">
                            <button class="btn btn-default btn-xs dropdown-toggle" type="button" 
                            data-toggle="dropdown" aria-expanded="false">Acciones <span class="caret"></span></button>
                            <ul class="dropdown-menu" role="menu">
                               <li><a href="asignar_docente.php?idmateria=' . $row[0] . '">Asignar Docente</a></li>
                                <li><a href="asignar_correlativas.php?curricula=' . $row[0] . '">Asignar Correlativas</a></li>
                            </ul> </div>';
                echo'<tr><td>' . utf8_encode($row[1]) . '</td><td>'.utf8_encode($row[3]).' '.utf8_encode($row[4]).'</td><td>' . $boton . '</td></tr>';
            }
            echo '</tbody></table></div>';
        }
        ?>
    </body>
</html>
