<?php
namespace AGD\Profiler;

require $_SERVER['DOCUMENT_ROOT'] . '/profiler-api/utils/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/profiler-api/utils/http.php';

use Exception;
use PDOException;

Http::SetDefaultHeaders('GET');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    Http::ReturnError(405, array('message' => 'Request method is not allowed.'));
    return;
}

$id = 0;

if (array_key_exists('id', $_GET)) {
    $id = intval($_GET['id']);
}

try {
    if ($id === 0) {
        $db = new Db('SELECT * FROM `students`'); 
        $db->execute();
        $records = $db->fetchAll();
        $rowCount = count($records);
        // if ($db->rowcount() === 0) {
        //     Http::ReturnError(404, array('message' => 'No records.'));
        // } else {
            // $records = $db->fetchAll();       
            Http::ReturnSuccess($rowCount);    
            Http::ReturnSuccess($records);
        // }       
    } else {
        $db = new Db('SELECT * FROM `students` WHERE id = :id LIMIT 1');
        $db->bindParam(':id', $id);
        $db->execute();
        if ($db->rowcount() === 0) {
            Http::ReturnError(404, array('message' => 'Object not found.'));
        } else {
            $record = $db->fetchAll()[0];
            Http::ReturnSuccess($record);
        }
    }
} catch (PDOException $pe) {
    Db::ReturnDbError($pe);
} catch (Exception $e) {
    Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
}