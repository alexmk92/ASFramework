<?php
namespace Models;
/*
|--------------------------------------------------------------------------
| Database
|--------------------------------------------------------------------------
|
| The database class maintains a single connection to the server and
| utilises PDO for safe parameter binding.  This is required to
| stop malicious users for exposing application logic.
|
| Connection pooling is not available in PHP, therefore using a singleton
| is a good way of solving performance overheads. Only one conn will be
| established per connection basis.
|
*/
class Database
{
    /*
    |--------------------------------------------------------------------------
    | Local vars
    |--------------------------------------------------------------------------
    |
    | Declare any local variable which the class should access
    | $instance   - the single instanciated instance of the class (singleton)
    | $connection - the connection to the database
    |
    */
    private static $instance;
    public         $connection;
    /*
    |--------------------------------------------------------------------------
    | Construct
    |--------------------------------------------------------------------------
    |
    | Builds the database and sets the connection, applying the singleton
    | pattern to allow one open instaciation socket to the DB
    |
    */
    private function __construct($debug)
    {
        // Create the connection
        $conn = include "./app/core/conf/database.php";
        $this->connection = new \PDO('mysql:host='.$conn['db_host'].'; dbname='.$conn['db_name'].';charset=utf8', $conn['db_user'], $conn['db_pass']);
        $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE , $conn['fetch']);
        // Set the error mode.
        if($debug)
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        else
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_SILENT);
    }
    /*
    |--------------------------------------------------------------------------
    | Get instance
    |--------------------------------------------------------------------------
    |
    | Returns the set instance to ensure only one socket stays open.
    |
    | @return Database - The instance of this class.
    |
    */
    public static function getInstance($debug = false)
    {
        $object = __CLASS__;
        !isset(self::$instance) ? self::$instance = new $object($debug) : false;
        return self::$instance;
    }
    /*
    |--------------------------------------------------------------------------
    | Fetch
    |--------------------------------------------------------------------------
    |
    | Returns the first resource from the server from the given query
    |
    | @param $query - The query to be executed
    | @param $data  - Key value pairs of data to be bound to query
    |
    */
    public function fetch($query, $data = null)
    {
        $stmt = $this->prepareQuery($query, $data);
        return  $stmt->fetchObject();
    }
    /*
    |--------------------------------------------------------------------------
    | Fetch All
    |--------------------------------------------------------------------------
    |
    | Returns all resources from the server which match the given query.
    |
    | @param $query - The query to be executed
    | @param $data  - Key value pairs of data to be bound to query
    |
    */
    public function fetchAll($query, $data = null)
    {
        $stmt = $this->prepareQuery($query, $data);
        return  $stmt->fetchAll();
    }
    /*
    |--------------------------------------------------------------------------
    | Insert Record
    |--------------------------------------------------------------------------
    |
    | Inserts a new record into the database, based on the variables passed by
    | the client.  These are sanitised in the prepare statement.
    |
    | @param $query - The query to be executed
    | @param $data  - Key value pairs of data to be bound to query
    |
    | @return $id   - The newly inserted id of this record, we can assert to
    |                 ensure that this is not 0 on the client.
    |
    */
    public function insert($query, $data)
    {
        $this->connection->prepare($query)->execute($data);
        return $this->connection->lastInsertId();
    }
    /*
    |--------------------------------------------------------------------------
    | Update Record
    |--------------------------------------------------------------------------
    |
    | Updates a new in the database, based on the variables passed by
    | the client.  These are sanitised in the prepare statement.
    |
    | @param $query - The query to be executed
    | @param $data  - Key value pairs of data to be bound to query
    |
    | @return $id   - The number of rows in the updated resource
    |
    */
    public function update($query, $data)
    {
        $stmt = $this->prepareQuery($query, $data);
        return $stmt->rowCount();
    }
    /*
    |--------------------------------------------------------------------------
    | Delete Record
    |--------------------------------------------------------------------------
    |
    | Deletes the record from the system and returns the new row count from
    | that resource.
    |
    | @param $query - The query to be executed
    | @param $data  - Key value pairs of data to be bound to query
    |
    | @return $id   - The number of rows in the resource
    |
    */
    public function delete($query, $data)
    {
        $stmt = $this->prepareQuery($query, $data);
        return $stmt->rowCount();
    }
    /*
    |--------------------------------------------------------------------------
    | Prepare Query
    |--------------------------------------------------------------------------
    |
    | Safely binds and executes the query by using prepared statements.  This
    | will sanitise any information sent to the script to void an SQL injection
    | attack against the system.
    |
    | @param $query  - The query to execute on the system
    | @param $params - The key value pairs to be bound to the query, i.e
    |                  ":username" => "user123" would bind user123 to :username
    |                  in the prepared statement.
    |
    | @return $stmt  - The safely prepared query.
    |
    */
    private function prepareQuery($query, $data = null)
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($data);
        return $stmt;
    }
}