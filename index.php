<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <div class="page-header">
            <h1>Bienvenidos.<small> Iniciar con usuario y contraseña</small></h1>
        </div>
        <div align="center" style="width: 40%">
            <form class="form-horizontal" role="form" action="validar.php" method="post">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Usuario</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control"  name="usuario" required autofocus placeholder="Usuario">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Contraseña</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="pass" required placeholder="Contraseña">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Aceptar</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
