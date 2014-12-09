<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<?php
//var_dump($_REQUEST);
require_once 'includes/funciones.php';
$proxy=  conectar();
$apellido = sanitizeMySQL($_REQUEST['apellido']);
$id = sanitizeMySQL($_REQUEST['id']);
$nombre = sanitizeMySQL($_REQUEST['nombre']);
$tipo = sanitizeMySQL($_REQUEST['tipo']);
$nro = sanitizeMySQL($_REQUEST['numero']);
$sexo = sanitizeMySQL($_REQUEST['sexo']);

$fnac = sanitizeMySQL(cambiarfecha_mysql($_REQUEST['fnac']));
$nacionalidad = sanitizeMySQL($_REQUEST['nacionalidad']);
$ecivil = sanitizeMySQL($_REQUEST['ecivil']);
$direccion = sanitizeMySQL($_REQUEST['direccion']);
$localidad = sanitizeMySQL($_REQUEST['localidad']);
$cpostal = sanitizeMySQL($_REQUEST['cpostal']);

$tel = sanitizeMySQL($_REQUEST['tel']);
$email = sanitizeMySQL($_REQUEST['email']);
$fegreso = sanitizeMySQL(cambiarfecha_mysql($_REQUEST['fegreso']));
$observ = sanitizeMySQL($_REQUEST['observaciones']);

$sql= "UPDATE `alumnos` set 
        `Apellido` = '$apellido',
        `Nombre` = '$nombre',
        `Sexo` = '$sexo',
        `TipoDocumento` = '$tipo',
        `NroDocumento` = '$nro',
        `FechaNacimiento` = '$fnac',
        `Id_Nacionalidad` = '$nacionalidad',
        `EstadoCivil` = '$ecivil',
        `Direccion` = '$direccion',
        `Localidad` = '$localidad',
        `CodigoPostal` = '$cpostal',
        `Telefono` = '$tel',
        `Email` = '$email',
        `FechaEgreso` = '$fegreso',
        `Observaciones` = '$observ'
      WHERE `Id` = '$id'";

if($result=$proxy->query($sql)){
   echo '<div class="alert alert-success" role="alert">Datos Modificados</div>';
}else{
   echo '<div class="alert alert-danger" role="alert">Error</div>';  
}
?>

