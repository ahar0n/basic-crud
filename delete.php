<?php
require 'database.php';
$id = 0;

if ( !empty($_GET['id']) ) {
    $id = $_GET['id'];
}

if ( !empty($_POST) ) {
    $dbh = Database::connect();
    $sql = "DELETE FROM cliente WHERE id = ?";
    $stm = $dbh->prepare($sql);
    $stm->execute( array($_POST['id']) );
    Database::disconnect();
    header("location: index.php?reg=3");
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
        <title>Actualizar registro</title>
    </head>
	<body>
	    <!-- begin container -->
	    <div class="container">
			<h3>Eliminar registro</h3>
			<div class="panel panel-default col-sm-offset-3 col-sm-6">
				<div class="panel-body">
					<form class="form" action="delete.php" method="post">
						<input type="hidden" name="id" value="<?php echo $id;?>"/>
						<button type="submit" class="btn btn-danger btn-block" href="delete.php">Eliminar definitivamente el registro</button>
				  		<a class="btn btn-default btn-block" href="index.php">Cancelar</a>
					</form>
			  	</div>
			</div>
		</div>
		<!-- end container -->
	</body>
</html>
