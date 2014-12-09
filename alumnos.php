<?php
require_once 'includes/funciones.php';
if (isset($_REQUEST['id'])) {
    $id_alumno = limpiaString($_REQUEST['id']);
    $proxy = conectar();
    $sql = "SELECT
                `alumnos`.`Apellido`
                , `alumnos`.`Nombre`
                , `alumnos`.`Sexo`
                , `documento`.`nombre` AS `documento`
                , `alumnos`.`NroDocumento`
                , DATE_FORMAT(`alumnos`.`FechaNacimiento`,'%d/%m/%Y') as fnac
                , `nacionalidades`.`Descripcion` as nacionalidad
                , `alumnos`.`EstadoCivil`
                , `alumnos`.`Direccion`
                , `alumnos`.`Localidad`
                , `alumnos`.`CodigoPostal`
                , `alumnos`.`Telefono`
                , `alumnos`.`Email`
                , DATE_FORMAT(`alumnos`.`FechaEgreso`,'%d/%m/%Y') as fegreso
                , `alumnos`.`Observaciones`
            FROM
                `documento`
                INNER JOIN `alumnos` 
                    ON (`documento`.`id` = `alumnos`.`TipoDocumento`)
                INNER JOIN `nacionalidades` 
                    ON (`nacionalidades`.`Id_Nacionalidad` = `alumnos`.`Id_Nacionalidad`)
            WHERE (`alumnos`.`Id` ='$id_alumno');";
    if ($result = $proxy->query($sql)) {
        while ($row = $result->fetch_array()) {
            $nombre = $row[1];
            $apellido = $row[0];
            $sexo = $row[2];
            $tipodoc = $row[3];
            $nrodoc = $row[4];
            $fnac = $row[5];
            $nacionalidad = $row[6];
            $ecivil = $row[7];
            $direccion = $row[8];
            $localiad = $row[9];
            $cpostal = $row[10];
            $telefono = $row[11];
            $email = $row[12];
            $fegreso = $row[13];
            $observ = $row[14];
        }
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="normalize.css">

        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">

    </head>
    <body>
        <div class="row">
            <h3>AAlumnos <small>Datos personales</small></h3>
        </div>
        <form method="post" action="modificar_alumnos.php">
            <input type="hidden" name="id" value="<?php echo $id_alumno ?>">
            <div style="width: 40%;float: left;">
                <div class="container-fluid">

                    <div class="form-group"> 
                        <label for="nombre">Nombre</label>
                        <input type="text" autofocus class="form-control" required name="nombre" id="nombre" 
                               placeholder="Nombre" <?php if (isset($nombre)) echo 'value="' . $nombre . '"' ?>>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" class="form-control" required name="apellido" id="apellido"
                               placeholder="Apellido" <?php if (isset($apellido)) echo 'value="' . $apellido . '"' ?>>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Tipo</label>
                        <select name="tipo"  id="tipo"  class="form-control" required>
                            <?php
                            $conex = conectar();
                            $sql = 'select id,nombre from documento order by nombre';

                            if ($result = $conex->query($sql)) {

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
                        <label for="apellido">Numero</label>
                        <input type="text" class="form-control" required name="numero" id="numero" 
                               placeholder="Documento" <?php if (isset($nrodoc)) echo 'value="' . $nrodoc . '"' ?>>
                    </div>            

                    <div class="form-group">
                        <label for="apellido">Sexo</label>
                        <select name="sexo" id="sexo"  class="form-control" required>
                            <option value="M" <?php
                            if (isset($sexo) and $sexo == "M") {
                                echo 'selected="selected"';
                            }
                            ?>>Masculino</option>
                            <option value="F" <?php
                            if (isset($sexo) and $sexo == "F") {
                                echo 'selected="selected"';
                            }
                            ?>>Femenino</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="apellido">Fecha de Nacimieto</label>
                        <input type="text" class="form-control" required name="fnac" id="datepicker" 
                               placeholder="Fecha Nac." <?php if (isset($fnac)) echo 'value="' . $fnac . '"' ?> >
                    </div>                 

                    <div class="form-group">
                        <label for="apellido">Nacionalidad</label>
                        <select name="nacionalidad" id="nacionalidad"  class="form-control" required>
                            <?php
                            $conex = conectar();
                            $sql = 'select id_nacionalidad as id,descripcion as nombre from nacionalidades order by nombre';

                            if ($result = $conex->query($sql)) {

                                while ($row = $result->fetch_array()) {
                                    if (isset($nacionalidad) and $nacionalidad == trim($row ['nombre'])) {
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
                        <label for="apellido">Estado Civil</label>
                        <select name="ecivil" id="ecivil" class="form-control" required>
                            <option value="C" <?php
                                    if (isset($ecivil) and $ecivil == "C") {
                                        echo 'selected="selected"';
                                    }
                                    ?>>Casado</option>
                            <option value="S"<?php
                                    if (isset($ecivil) and $ecivil == "S") {
                                        echo 'selected="selected"';
                                    }
                                    ?>>Soltero   </option>

                        </select>
                    </div>


                </div>
            </div>
            <div style="width: 10%;float: left;">

            </div>
            <div style="width: 40%;float: left;">
                <div class="container-fluid">
                    <div class="form-group">
                        <label for="apellido">Direccion</label>
                        <input type="text" class="form-control" required name="direccion" id="direccion" 
                               placeholder="Direccion"  <?php if (isset($direccion)) echo 'value="' . $direccion . '"' ?>>
                    </div>               
                    <div class="form-group">
                        <label for="apellido">Localidad</label>
                        <input type="text" class="form-control" required name="localidad" id="localidad" 
                               placeholder="Localidad"  <?php if (isset($localiad)) echo 'value="' . $localiad . '"' ?>>
                    </div>          
                    <div class="form-group">
                        <label for="apellido">Codigo Postal</label>
                        <input type="text" class="form-control" required name="cpostal" id="cpostal" 
                               placeholder="C. Postal"  <?php if (isset($cpostal)) echo 'value="' . $cpostal . '"' ?>>
                    </div>  
                    <div class="form-group">
                        <label for="apellido">Telefono</label>
                        <input type="tel" class="form-control" required name="tel" id="tel" 
                               placeholder="Telefono"  <?php if (isset($telefono)) echo 'value="' . $telefono . '"' ?>>
                    </div>  
                    <div class="form-group">
                        <label for="apellido">Correo Electronico</label>
                        <input type="email" class="form-control" required name="email" id="email" 
                               placeholder="C.Electronico"  <?php if (isset($email)) echo 'value="' . $email . '"' ?>>
                    </div>  
                    <div class="form-group">
                        <label for="apellido">Fecha de Egreso</label>
                        <input type="text" class="form-control" required name="fegreso" id="fegreso" 
                               placeholder="F. Egreso"  <?php if (isset($fegreso)) echo 'value="' . $fegreso . '"' ?>>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Observaciones</label>
                        <textarea name="observaciones" id="observaciones" class="form-control" > <?php if (isset($observ)) echo $observ; ?></textarea>
                        <!--<input type="email" class="form-control" required name="numero" id="numero" placeholder="F. Egreso">-->
                    </div>

                </div>
            </div>
            <div align="center">
                <input class="btn btn-primary" type="submit" name="submit" value="Aceptar">
            </div> 
        </form>

    </body>
</html>
<script type="text/javascript">
    jQuery(function ($) {
        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '&#x3c;Ant',
            nextText: 'Sig&#x3e;',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
                'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Mi&eacute;rcoles', 'Jueves', 'Viernes', 'S&aacute;bado'],
            dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mi&eacute;', 'Juv', 'Vie', 'S&aacute;b'],
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'S&aacute;'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
            defaultDate: "-18y",
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''};
        $.datepicker.setDefaults($.datepicker.regional['es']);
    });

    $(document).ready(function () {
        $("#datepicker").datepicker({
            changeMonth: true,
            minDate: new Date(1910, 1, 1),
            maxDate: new Date(),
            numberOfMonths: 2,
            setDate: new Date(1978, 7, 17),
            changeYear: true,
            autoSize: true,
            //    appendText: ' Haga click para introducir una fecha',
            //  maxDate: new Date(2010, 9, 30),
//                    showOn: "button",
//                    buttonImage: "images/calendar.gif",
//                    buttonImageOnly: true
        });
    });

    $(document).ready(function () {
        $("#fegreso").datepicker({
            changeMonth: true,
            minDate: new Date(1910, 1, 1),
            maxDate: new Date(),
            numberOfMonths: 2,
            setDate: new Date(1978, 7, 17),
            changeYear: true,
            autoSize: true,
            //    appendText: ' Haga click para introducir una fecha',
            //  maxDate: new Date(2010, 9, 30),
//                    showOn: "button",
//                    buttonImage: "images/calendar.gif",
//                    buttonImageOnly: true
        });
    });
</script>