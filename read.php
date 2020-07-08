<?php
    require 'database.php';
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }

    if ( null==$id ) {
        header("Location: index.php");
    } else {
        $dbh = Database::connect();
        $sql = "SELECT * FROM cliente where id = ?";
        $stm = $dbh->prepare($sql);
        $stm->execute( array($id) );
        $cliente = $stm->fetch( PDO::FETCH_ASSOC );
        Database::disconnect();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<title>Ver registro</title>
</head>

<body>
    <div class="container">
	    <h3>Datos del cliente</h3>

		<div class="panel panel-default col-sm-offset-2 col-sm-8">
            <table class="table">
				<tbody>
					<tr>
						<td class="col-md-1">Nombre:</td>
						<th><?php echo $cliente['nombre']; ?></th>
					</tr>
					<tr>
						<td>Apellido:</td>
						<th><?php echo $cliente['apellido']; ?></th>
					</tr>
					<tr>
						<td>E-mail:</td>
						<th><?php echo $cliente['email']; ?></th>
					</tr>
					<tr>
						<td>Telefono:</td>
						<th><?php echo $cliente['telefono']; ?></th>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="col-sm-offset-2 col-sm-8">
			<a class="btn btn-default" href="index.php">Volver</a>
		</div>
    </div> <!-- /container -->
 </body>
</html>
