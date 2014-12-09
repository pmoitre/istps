<?php
require_once 'includes/iniciar_sesion.php';
require_once 'includes/funciones.php';
$lugar = $_SESSION['idlugar'];
$idrol = $_SESSION['idrol'];
$idcarrera = $_SESSION['idcarrera'];
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <!--<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">-->
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
    </head>
    <body>
        <div class="panel panel-info">
            <div class="panel-heading">Busqueda de alumnos</div>
            <div class="panel-body">

                <div style="width:45%;float:left;">
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input autofocus type="text" class="form-control" required name="apellido" id="apellido"
                               placeholder="Apellido">
                    </div>
                    <div class="form-group">
                        <label for="documento">Documento</label>
                        <input type="text" class="form-control" required name="documento" id="documento"
                               placeholder="Documento">
                    </div>

                </div>
                <div style="width:45%;float:left;">
                    <div class="form-group">
                        <label for="carrera">Carrera</label>
                        <select name="carrera"  id="carrera"  class="form-control">
                            <?php
                            $conex = conectar();

                            if ($idrol == '2' or $idrol == '1') {
                                  $sql = 'select idespecialidad as id,descripcion as nombre from especialidades order by nombre';
                            } else {
                                  $sql = "select idespecialidad as id,descripcion as nombre from especialidades where idespecialidad = '$idcarrera' order by nombre";
                            }
                          

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
                    </div> 
                    <div class="form-group">
                        <label for="lugar">Sede</label>
                        <select name="lugar"  id="sede"  class="form-control">
                            <?php
                            $conex = conectar();

                            if ($idrol == '2' or $idrol == '1') {
                                $sql = 'select idinstitucion as id,nombre from instituciones order by nombre';
                            } else {
                                $sql = "select idinstitucion as id,nombre from instituciones where idinstitucion = '$lugar' order by nombre";
                            }



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
                    </div> 

                </div>
                <div align="center" style="width: 45%;">
                    <input  value ="Buscar" class="btn btn-primary" type="button" name="boton" 
                            onClick="realizaProceso1($('#documento').val(), $('#apellido').val(), $('#carrera').val(), $('#sede').val());
                                    return false;">

                </div>
            </div>
        </div>
        <p>
            <span id="lprestaciones1"></span></p>
    </body>
</html>
<script>

    function realizaProceso1(documento, apellido, carrera,sede)
    {
        var parametros = {
            "documento": documento,
            "apellido": apellido,
            "carrera": carrera,
            "sede": sede


        };
        $.ajax({
            data: parametros,
            url: 'BuscarAlumno.php',
            type: 'post',
            beforeSend: function() {
                $("#lprestaciones1").html("Procesando, espere por favor...");
            },
            success: function(response) {
                $("#lprestaciones1").html(response);
            }
        });
    }
</script>
