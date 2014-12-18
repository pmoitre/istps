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
        <form action="" method="post">
            <div style="width: 50%">
                <div  class="form-group">



                    <div class="form-group">
                        <label for="Nombre">Nombre</label>
                        <input autofocus type="text" class="form-control" required name="nombre" id="nombre"
                               placeholder="Nombre de la curricula">

                    </div>
                    <label for="carrera">Carrera</label>
                    <select name="carrera"  id="carrera"  class="form-control">
                        <?php
                        $conex = conectar();

                        $sql = "SELECT
                            `idespecialidad` as id
                            , `descripcion` as nombre
                        FROM
                            especialidades 
                       WHERE idespecialidad NOT IN 
                            (SELECT idcarrera FROM curricula WHERE activa = '1') 
                       order by 2";

                        if ($result = $conex->query($sql)) {
//                                echo "<option value='0'>*Todas</option>";
                            while ($row = $result->fetch_array()) {
                                if (isset($tipodoc) and $tipodoc == trim($row ['nombre'])) {
                                    echo "<option selected='selected' value='" . $row['id'] . "'> " . utf8_encode(trim($row['nombre'])) . "</option>";
                                } else {
                                    echo "<option value='" . $row['id'] . "'> " . utf8_encode(trim($row['nombre'])) . "</option>";
                                }
                            }
                            unset($row);
                            desconectar($conex);
                        } else {
                            echo 'error' . $conex->error;
//                            exit();
                        }
                        ?>
                    </select>
                </div></div>
            <div align="center">
                <input class="btn btn-primary" type="submit" name="submit" value="Aceptar">
            </div> 
        </form>
    </body>
</html>
