<?php
require_once 'includes/config.php';


function conectar() {
    $conexion = new mysqli('127.0.0.1', DB_USER, DB_PASS, DB_NAME);
    if ($conexion->connect_error) {
        echo 'Error de Conexion ' . $mysqli->conection_error;
        die();
    }
    return $conexion;
}

function desconectar($obj_conex) {
    return $obj_conex->close();
}

function extension($str) {
    return end(explode(".", $str));
}

function FileUploadErrorMsg($error_code) {
    switch ($error_code) {
        case UPLOAD_ERR_INI_SIZE:
            return "El archivo es más grande que lo permitido por el Servidor.";
        case UPLOAD_ERR_FORM_SIZE:
            return "El archivo subido es demasiado grande.";
        case UPLOAD_ERR_PARTIAL:
            return "El archivo subido no se terminó de cargar (probablemente cancelado por el usuario).";
        case UPLOAD_ERR_NO_FILE:
            return "No se subió ningún archivo";
        case UPLOAD_ERR_NO_TMP_DIR:
            return "Error del servidor: Falta el directorio temporal.";
        case UPLOAD_ERR_CANT_WRITE:
            return "Error del servidor: Error de escritura en disco";
        case UPLOAD_ERR_EXTENSION:
            return "Error del servidor: Subida detenida por la extención";
        default:
            return "Error del servidor: " . $error_code;
    }
}

function messagebox($mensaje) {
    ?>    
    <script type='text/javascript'>
        alert("<?php echo $mensaje ?>");
    </script>  
    <?php
}

function limpiaString($var) {
    $var = stripslashes($var);
    $var = htmlentities($var);
    $var = strip_tags($var);
    return $var;
}

function sanitizeMySQL($var) {
    $var = mysql_real_escape_string($var);
    $var = limpiaString($var);
    return $var;
}

function cambiarfecha_mysql($fecha) {
    list($dia, $mes, $ano) = explode("/", $fecha);
    $fecha = "$ano-$mes-$dia";
    return $fecha;
}

function Geolookup($string) {

    $string = str_replace(" ", "+", urlencode($string));
    $details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $string . "&sensor=false";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $details_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = json_decode(curl_exec($ch), true);

    // If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
    if ($response['status'] != 'OK') {
        return null;
    }

//   print_r($response);
    $geometry = $response['results'][0]['geometry'];

    $longitude = $geometry['location']['lat'];
    $latitude = $geometry['location']['lng'];

    $array = array(
        'latitude' => $geometry['location']['lng'],
        'longitude' => $geometry['location']['lat'],
        'location_type' => $geometry['location_type'],
    );

    return $array;
}
?>
<script language="javascript">

    function ir(url)
    {

        window.location.href = url;
    }

</script>
<script language="javascript">
    function Volver()
    {
        window.history.go(-1);
    }

</script>