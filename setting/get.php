<?php
namespace AGD\Profiler;

require $_SERVER['DOCUMENT_ROOT'] . '/profiler-api/utils/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/profiler-api/utils/http.php';
require $_SERVER['DOCUMENT_ROOT'] . '/profiler-api/models/setting.php';

use Exception;
use PDOException;

Http::SetDefaultHeaders('GET');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    Http::ReturnError(405, array('message' => 'Request method is not allowed.'));
    return;
}

$id = 0;

if (array_key_exists('name', $_GET)) {
    $id = $_GET['name'];
}

try {
    if ($id === 0) {
        $db = new Db('SELECT * FROM `settings`');
        $response = array();
        $db->execute();
        $records = $db->fetchAll();
        $rowCount = count($records);
        if ($rowCount > 0) {
            foreach ($records as &$record) {
                $value = new Setting($record);
                array_push($response, $value);
            }
        }  
        Http::ReturnSuccess($response);
    } else {
        $db = new Db('SELECT * FROM `settings` WHERE name = :name LIMIT 1');
        $db->bindParam(':name', $name);
        $db->execute();
        $records = $db->fetchAll();
        $rowCount = count($records);
        if ($rowCount > 0) {
            $record = $records[0];
            $value = new Setting($record);            
        }
        Http::ReturnSuccess($value);
    }
} catch (PDOException $pe) {
    Db::ReturnDbError($pe);
} catch (Exception $e) {
    Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
}