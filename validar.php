<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<meta charset="UTF-8">
<?php
require_once 'includes/funciones.php';

$usuario = limpiaString($_REQUEST['usuario']);
$pass = limpiaString($_REQUEST['pass']);

$proxy = conectar();
$sql = "select idrol,idlugar,idcarrera from usuarios where nombre='$usuario' and clave = sha('$pass')";
if ($result = $proxy->query($sql)) {
    if ($result->num_rows == 1) {
        session_start();
        while($row = $result->fetch_array()){
            $_SESSION['idrol'] = $row[0];
            $_SESSION['idlugar'] = $row[1];
            $_SESSION['idcarrera'] = $row[2];
            $_SESSION['user'] = $usuario;
            
        }
        header('location:inicio.php');
        
    } else {
        echo '<div class="alert alert-danger" role="alert">Usuario o contraseña incorrecta. Intente nuevamente</div>';
    }
}
