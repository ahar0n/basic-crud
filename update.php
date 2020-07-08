<?php
require 'database.php';

if ( !empty($_GET['id']) ) {
    $id = $_REQUEST['id'];
} else {
    header( "Location: index.php" );
}

if ( !empty($_POST) ) {
    $nombreError = null;
    $apellidoError = null;
    $emailError = null;
	$telefonError = null;

    $nombre = $_POST['nombre'];
	$apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];

    $valid = true;
    if ( empty($nombre) ) {
        $nombreError = ' Ingrese nombre';
        $valid = false;
    }

    if ( empty($apellido) ) {
        $apellidoError = ' Ingrese apellido';
        $valid = false;
    }

    if (empty($email)) {
        $emailError = ' Ingrese email';
        $valid = false;
    } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
        $emailError = ' Debe ingresar una direccion de e-mail valida';
        $valid = false;
    }

    $expresion = '/^[0-9]{9}$/';
    if ( empty($telefono) ) {
        $telefonoError = ' Debe ingresar un numero de telefono';
        $valid = false;
    } else if( !preg_match( $expresion, $telefono ) ){
        $telefonoError = ' Ingrese un numero de telefono valido';
        $valid = false;
    }

    if ($valid) {
        $dbh = Database::connect();
        $sql = "UPDATE cliente SET nombre = :nombre, apellido = :apellido, email = :email, telefono = :telefono WHERE id = :id";
        $stm = $dbh->prepare($sql);
		$cliente = array(
            ':nombre' => $nombre,
            ':apellido' => $apellido,
            ':email' => $email,
            ':telefono' => $telefono,
            ':id' => $id );
        if ( $stm->execute($cliente) ) {
            Database::disconnect();
            header("Location: index.php?reg=2");
        }
    }
} else {
    $dbh = Database::connect();
    $sql = "SELECT * FROM cliente WHERE id = :id";
    $stm = $dbh->prepare($sql);
    $stm->execute( array(':id' => $id) );
    $cliente = $stm->fetch( PDO::FETCH_ASSOC );
    $nombre = $cliente['nombre'];
	$apellido = $cliente['apellido'];
    $email = $cliente['email'];
    $telefono = $cliente['telefono'];
    Database::disconnect();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <title>Agregar nuevo registro</title>
</head>

<body>
    <div class="container">
        <h3>Agregar nuevo registro</h3>

		<div class="panel panel-default col-sm-offset-2 col-sm-8">
            <div class="panel-body">

                <form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
                    <div class="form-group <?php echo !empty($nombreError) ?'has-error':'';?>">
                        <label for="nombre" class="col-sm-2 control-label">Nombre</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nombre" placeholder="Nombre" value="<?php echo !empty($nombre)?$nombre:''; ?>">
                        </div>
                        <div class="col-sm-offset-3">
                            <div class="text text-danger" role="alert">
                            <?php
                            if (!empty($nombreError)){
                                echo '<span class="glyphicon glyphicon-exclamation-sign"></span>' . $nombreError;
                            }
                            ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group <?php echo !empty($apellidoError) ?'has-error':'';?>">
                        <label for="apellido" class="col-sm-2 control-label">Apellido</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="apellido" placeholder="Apellido" value="<?php echo !empty($apellido)?$apellido:'';?>">
                        </div>
                        <div class="col-sm-offset-3">
                            <div class="text text-danger" role="alert">
                            <?php
                            if (!empty($apellidoError)){
                                echo '<span class="glyphicon glyphicon-exclamation-sign"></span>' . $apellidoError;
                            }
                            ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group <?php echo !empty($telefonoError) ?'has-error':'';?>">
                        <label for="fono" class="col-sm-2 control-label">Telefono</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="telefono" placeholder="Telefono" value="<?php echo !empty($telefono)? $telefono:'';?>">
                        </div>
                        <div class="col-sm-offset-3">
                            <div class="text text-danger" role="alert">
                            <?php
                            if (!empty($telefonoError)){
                                echo '<span class="glyphicon glyphicon-exclamation-sign"></span>' . $telefonoError;
                            }
                            ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group <?php echo !empty($emailError) ?'has-error':'';?>">
                        <label for="email" class="col-sm-2 control-label">E-mail</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" placeholder="e-mail" value="<?php echo !empty($email)?$email:'';?>">
                        </div>
                        <div class="col-sm-offset-3">
                            <div class="text text-danger" role="alert">
                            <?php
                            if (!empty($emailError)){
                                echo '<span class="glyphicon glyphicon-exclamation-sign"></span>' . $emailError;
                            }
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                            <a class="btn btn-default" href="index.php">Volver</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
