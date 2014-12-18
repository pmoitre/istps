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
                <li role="presentation" class="active"><a href="#">Curricula</a></li>
                <li role="presentation"><a href="materias.php">Materias</a></li>

            </ul>
        </div>
        <?php
        echo '<div align="left"><div align="left" class="btn-group" role="group" aria-label="...">
            <button type="button" class="btn btn-default">Nuevo</button>
            
          </div></div>';
        $sql = "SELECT
                    `curricula`.`id`
                    , `curricula`.`nombre`
                    , `especialidades`.`descripcion`
                FROM
                    `especialidades`
                    INNER JOIN `curricula` 
                        ON (`especialidades`.`idespecialidad` = `curricula`.`idcarrera`)
                WHERE (`curricula`.`activa` ='1');"; //42455422

        $conex = conectar();

        if ($result = $conex->query($sql)) {
            echo '<div style="width:75%;float:left"><table class="table table-striped">';
            echo '<thead><h4><td>Nombre</td><td>Carrera</td><td></td></h4></thead>';
            echo '<tbody>';
            while ($row = $result->fetch_array()) {
                $boton = '        <!-- Extra small button group -->
                        <div class="btn-group">
                            <button class="btn btn-default btn-xs dropdown-toggle" type="button" 
                            data-toggle="dropdown" aria-expanded="false">
                                Acciones <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="materias.php?curricula=' . $row[0] . '">Ver Materias</a></li>
                                
                            </ul> </div>';
                echo'<tr><td>' . utf8_encode($row[1]) . '</td><td>' . utf8_decode($row[2]) . '</td><td>' . $boton . '</td></tr>';
            }
            echo '</tbody></table></div>';
        }
        ?>
    </body>
</html>
