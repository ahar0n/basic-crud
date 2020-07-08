<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <title>Proyecto CRUD</title>
    </head>
<body>
    <!-- begin container -->
    <div class="container">
        <h3>Tabla PHP CRUD</h3>

        <?php
        if ( isset($_GET['reg']) ) {
            if ( $_GET['reg'] == 1 ) {
                $msgType = 'alert-success';
                $msg = 'Registro agregado correctamente.';
            }
            
            if ( $_GET['reg'] == 2 ) {
                $msgType = 'alert-success';
                $msg = 'El registro fue actualizado correctamente.';
            }

            if ( $_GET['reg'] == 3 ) {
                $msgType = 'alert-success';
                $msg = 'El registro fue eliminado correctamente.';
            }

            echo '<div class="alert ' . $msgType . ' fade in" role="alert">';
            echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
            echo $msg;
            echo '</div>';
        }
        ?>

        <p>
            <a href="create.php" class="btn btn-primary">Nuevo registro</a>
        </p>

        <div class="panel panel-default">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="col-md-3">Nombre</th>
                        <th class="col-md-3">E-mail</th>
                        <th class="col-md-3">Telfono</th>
                        <th class="col-md-1">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'database.php';
                    $dbh = Database::connect();
                    /** $sql consulta SQL (query)
                     * La consulta de datos se realiza mediante
                     * PDOStatement::fetch, que obtiene la siguiente fila de un
                     * conjunto de resultados.
                    */
                    $sql = 'SELECT * FROM cliente ORDER BY nombre ASC';
                    /**
                     * [$stm crea una instancia PDOstatement]
                     * @var [PDOstatement] clase que trata las sentencias SQL.
                     */
                    $stm = $dbh->prepare($sql);
                    /**
                     * execute() envia los datos a la db
                     * Utilizando el metodo lazy (pasando valores por medio de
                     * un array)
                     */
                    $stm->execute();
                    /**
                     * fetchAll() devuelve un array con todas las filas que
                     * retorna la consulta a la db, las cuales se pueden iterar.
                     *
                     * PDO::FETCH_ASSOC: estilo de retorno que devuelve un
                     * array indexado cuyos keys son el nombre de las columnas.
                     */
                    $clientes = $stm->fetchAll( PDO::FETCH_ASSOC );
                    foreach ( $clientes as $cliente ) {
                        echo '<tr>';
                        echo '<td>'. $cliente['nombre'] . ' ' . $cliente['apellido'] . '</td>';
                        echo '<td>'. $cliente['email'] . '</td>';
                        echo '<td>'. $cliente['telefono'] . '</td>';
                        echo '<td align="center>">';
                        echo '<a style="padding: 0px 3px;" title="Mas detalles" class="glyphicon glyphicon-eye-open" href="read.php?id=' . $cliente['id'] . '"></a>';
                        echo '<a style="padding: 0px 3px;" title="Mas detalles" class="glyphicon glyphicon-pencil" href="update.php?id=' . $cliente['id'] . '"></a>';
                        echo '<a style="padding: 0px 3px;" title="Mas detalles" class="glyphicon glyphicon-remove" href="delete.php?id=' . $cliente['id'] . '"></a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    Database::disconnect();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!--  End container -->
</body>
</html>
