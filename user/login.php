<?php
namespace AGD\Profiler;

require $_SERVER['DOCUMENT_ROOT'] . '/utils/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/utils/http.php';
require $_SERVER['DOCUMENT_ROOT'] . '/models/user.php';

use Exception;
use PDOException;

Http::SetDefaultHeaders('GET');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    Http::ReturnError(405, array('message' => 'Request method is not allowed.'));
    return;
}

$username = 0;
$password = 0;

if (array_key_exists('username', $_GET)) {
    $username = $_GET['username'];
}

if (array_key_exists('password', $_GET)) {
    $password = $_GET['password'];
}

try {   
        $db = new Db('SELECT * FROM `users` WHERE username = :username AND password = :password LIMIT 1');
        $db->bindParam(':username', $username);
        $db->bindParam(':password', $password);
        $db->execute();
        $records = $db->fetchAll();
        $rowCount = count($records);
        if ($rowCount > 0) {
            $record = $records[0];
            $value = new User($record);
        }
        Http::ReturnSuccess($value);    
} catch (PDOException $pe) {
    Db::ReturnDbError($pe);
} catch (Exception $e) {
    Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
}