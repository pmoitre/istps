<?php require_once 'includes/funciones.php'; ?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
        $proxy = conectar();
        $id = limpiaString($_REQUEST['id']);
        if (isset($_REQUEST['submit'])) {
            if (isset($_REQUEST['secundario'])) {
                $sql = "update alumnos set titulo='1' where id='$id'";
                $proxy->query($sql);
            }
            if (isset($_REQUEST['afisico'])) {
                $sql = "update alumnos set apto_fisico='1' where id='$id'";
                $proxy->query($sql);
            }
            echo '
                    <div class="alert alert-success" role="alert">
                <a href="admin_alumnos.php" class="alert-link">Documentación Grabada...continuar</a>
              </div>';
            die();
        }

        $sql = "select titulo,apto_fisico from alumnos where id = '$id' ";
//        echo $sql;
        if ($result = $proxy->query($sql)) {
            while ($row = $result->fetch_array()) {
                if ($row[0] == '1') {
                    $titulo = '1';
                }
                if ($row[1] == '1') {
                    $aptofisico = '2';
                }
            }
        }
        ?>
        <form action="" method="post">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Documentación presentada</h3>
                </div>

                <input type="hidden" name="id" value="<?php echo limpiaString($_REQUEST['id']); ?>"> 
                <div class="panel-body">
                    <p>
                        <input type="checkbox" name="secundario" value="1" <?php if (isset($titulo)) {
            echo 'checked';
        } ?>>  Título secundario<br></p>
                    <p>
                        <input type="checkbox" name="afisico" value="2" <?php if (isset($aptofisico)) {
            echo 'checked';
        } ?>> Apto Físico<br></p>
                    <p>
                        <input  value ="Grabar Documentación" class="btn btn-primary" type="submit" name="submit" ></p>
                </div>
            </div>
        </form>    


    </body>
</html>
