<?php
/**
 * database.php conecta con la base de datos: conexion y desconexion
 * APIs alternativas para conectar con dbs:
 * 		MySQLi (procedimental) : soporte solo MySQL
 *   	PDO (POO) : soporte para 12 drivers
 * ver disponibles var_dump(PDO::getAvailableDrivers())
*/

class Database{
    private static $dbHost = '127.0.0.1:3306';
    private static $dbName = 'proyecto';
    private static $dbUser = 'root';
    private static $dbUserPass = 'mysqlroot';

    /** $dbh DataBase Handle, nombre habitualmente asignado a un objeto PDO */
    private static $dbh = null;

    /**
     * [__construct]
     * Considerando que es una 'clase estatica', la inicializacion de esta
     * clase no esta permitida.
     */
    public function __construct(){
        die( 'Funcion no permitida' );
    }

    /**
     * [connect : utiliza singleton pattern que permite una conexion a la vez]
     * Database::connect() para crear una conexion
     * @static
     * @return [PDO object] [instancia para consultar a la base de datos]
     */
    public static function connect(){

        if ( self::$dbh == null ) {
            try {
                /**
                 * [$dsn : data source name]
                 * e.g. MySQL : 'mysql:host=127.0.0.1;dbname=testdb';
                 */
                $dsn = 'mysql:host='.self::$dbHost.';dbname='.self::$dbName;
                $user = self::$dbUser;
                $pass = self::$dbUserPass;
                /**
                 * [$dbh description]
                 * @var PDO __construct
                 * @param [string] $dsn
                 * @param [string] $user
                 * @param [string] $pass
                 */
                self::$dbh = new PDO( $dsn, $user, $pass );
                /**
                 * Manejo de error (y excepciones) con PDO
                 * Se puede (y debe) especificar el modo de error estableciendo
                 * el atributo error mode:
                 *
                 * PDO::ERRMODE_EXCEPTION : PDO lanzara excepciones PDOException
                 * y establecera sus propiedades para luego reflejar el error
                 * y su informacion. Se aplica con el método PDO::setAttribute
                 */
                self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch ( PDOException $e ) {
                die( 'ERROR DE CONEXION: ' . $e->getMessage() );
            }
        }
        return self::$dbh;
    }

    /**
     * [disconnect : cerrar la conexion con la base de datos]
     * @static
     */
    public static function disconnect(){
        self::$dbh = null;
    }
}
