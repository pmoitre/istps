<?php
require_once 'includes/iniciar_sesion.php';
require_once 'includes/funciones.php';
if (isset($_REQUEST['accion']) and $_REQUEST['accion'] == 'eliminar') {
    $docente = limpiaString($_REQUEST['docente']);
    $materia = limpiaString($_REQUEST['materia']);
    $conex = conectar();
    $sql = "update materia_docente set activo='0',hasta=now() where id_materia='$materia' and id_docente='$docente'";
    if ($conex->query($sql)) {
        echo '<div class="alert alert-success" role="alert"><a href="?idmateria=' . $materia . '">Docente desafectado, continuar</a></div>';
    }

    desconectar($conex);
    die();
}
if(isset($_REQUEST['submit'])){
    $iddocente = $_REQUEST['docente'];
    $materia = $_REQUEST['idmateria'];
    $conex = conectar();
    
    $sql = "insert into materia_docente(id_materia,id_docente,activo,desde) value('$materia','$iddocente','1',now())";
//    echo $sql;
    if ($conex->query($sql)) {
        echo '<div class="alert alert-success" role="alert"><a href="?idmateria=' . $materia . '">Docente agregado, continuar</a></div>';
    }

    desconectar($conex);
    die();
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Asignacion de docentes</title>
    </head>
    <body>
        <form action="" method="post">
        <div class="panel panel-info">
            <div class="panel-heading">Docente Asignado</div>
            <div class="panel-body">
                <?php
                $idmateria = limpiaString($_REQUEST['idmateria']);
                echo '<input type="hidden" name="idmateria" value="'.$idmateria.'">';
                $conex = conectar();
                $sql = "SELECT
                `docente`.`id`
                , `docente`.`nombre`
                , `docente`.`apellido`
            FROM
                `docente`
                INNER JOIN `materia_docente` 
                    ON (`docente`.`id` = `materia_docente`.`id_docente`)
            WHERE `materia_docente`.`id_materia` ='$idmateria' and activo = '1' ";

                if ($result = $conex->query($sql)) {
                    $doc = $result->num_rows;
                    if ($doc > 0) {
                        echo '<div ><table class="table table-striped">';
                        echo '<thead><h4><td>Nombre</td><td>Apellido</td><td></td></h4></thead>';
                        echo '<tbody>';
                        while ($row = $result->fetch_array()) {


                            echo'<tr><td>' . utf8_encode($row[1]) . '</td><td>' . utf8_encode($row[2]) . '</td><td><a href="?accion=eliminar&docente=' . $row[0] . '&materia=' . $idmateria . '">Quitar Docente</a></td></tr>';
                        }
                        echo '</tbody></table></div>';
                    } else {
                        echo '<span class="label label-danger">No hay asignado</span>';
                    }
                    desconectar($conex);
                }
                ?>
            </div>   
        </div>

        <div>
            <label for="docente">Seleccione un docente</label>
            <select name = "docente" id = "docente" class = "form-control">
                <?php
                $conex = conectar();

                $sql = 'select id,nombre,apellido from docente order by apellido,nombre';


                if ($result = $conex->query($sql)) {
                    while ($row = $result->fetch_array()) {
                        echo "<option value='" . $row['id'] . "'> " . utf8_encode(trim($row['apellido']) . ' ' . trim($row['nombre'])) . "</option>";
                    }
                    unset($row);
                    desconectar($conex);
                } else {
                    echo 'error' . $conex->error;
//                            exit();
                }
                ?>
            </select>

            <?php
            $habilitado = '';
            if ($doc <> 0) {
                $habilitado = 'disabled="disabled"';
            }
            ?>
            <p>&nbsp;</p>
            <input  value ="Grabar" class="btn btn-primary"  <?php echo $habilitado; ?> type="submit" name="submit">
            <input  value ="Volver" class="btn btn-primary"  onclick="javascript:Volver()" type="button" name="atras">
            

        </div>
        </form>
    </body>
</html>
