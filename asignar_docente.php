<?php
require_once 'includes/iniciar_sesion.php';
require_once 'includes/funciones.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $idmateria = limpiaString($_REQUEST['idmateria']);
        $conex = conectar();
        $sql = "SELECT
                `docente`.`id`
                , `docente`.`nombre`
                , `docente`.`apellido`
            FROM
                `docente`
                INNER JOIN `materia_docente` 
                    ON (`docente`.`id` = `materia_docente`.`id_docente`)
            WHERE (`materia_docente`.`id_materia` ='$idmateria');";

        if ($result = $conex->query($sql)) {
            echo '<div style="width:75%;float:left"><table class="table table-striped">';
            echo '<thead><h4><td>Nombre</td><td>Apellido</td><td></td></h4></thead>';
            echo '<tbody>';
            while ($row = $result->fetch_array()) {


                echo'<tr><td>' . utf8_encode($row[1]) . '</td><td>' . utf8_encode($row[2]) . '</td><td><a href="?accion=eliminar&docente=' . $row[0] . '&materia=' . $idmateria . '">Quitar Docente</a></td></tr>';
            }
            echo '</tbody></table></div>';
        }
        ?>
    </body>
</html>
