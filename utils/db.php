<?php
namespace AGD\Profiler;
// Declare use on objects to be used
use PDO;
class Db
{
    private $pdo;
    private $statement;
    public function __construct($query)
    {
        // $this->pdo = new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] .'/profiler-api/utils/profiler.db');
        $this->pdo = new PDO('mysql:dbname=KnUEJ2VAWl;host=remotemysql.com;port=3306;', 'KnUEJ2VAWl', 'sC0m8bCARB');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->beginTransaction();
        $this->statement = $this->pdo->prepare($query);
    }
    public function bindParam($name, $value)
    {
        // Bind parameters
        $this->statement->bindParam($name, $value);
    }
    public function execute()
    {
        // Execute statement 
        return $this->statement->execute();
    }
    public function lastInsertId()
    {
        // Return last inserted id
        return $this->pdo->lastInsertId();
    }
    public function fetchAll()
    {
        // Return all records
        return $this->statement->fetchAll();
    }
    public function commit()
    {
        // Commit the transaction
        $this->pdo->commit();
    }
    public function rollback()
    {
        // Rollback the transaction
        $this->pdo->rollback();
    }
    public static function ReturnDbError($pe)
    {
        // Reply with error reponse
        $errorCode = $pe->getCode();
        if ((string) $errorCode === '23000' || (string) $errorCode === '22001') {
            $errorInfo = $pe->errorInfo;
            Http::ReturnError(400, array('message' => $errorInfo[2]));
        } else if ((string) $errorCode === '2002') {
            Http::ReturnError(500, array('message' => 'The database couldn\'t be reached.'));
        } else if ((string) $errorCode === '1045') {
            Http::ReturnError(500, array('message' => 'The database credentials are incorrect.'));
        } else {
            Http::ReturnError(500, array('message' => 'Server error: ' . $pe->getMessage() . '.'));
        }
    }
}