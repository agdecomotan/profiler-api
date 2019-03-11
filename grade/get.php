<?php
namespace AGD\Profiler;

require $_SERVER['DOCUMENT_ROOT'] . '/profiler-api/utils/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/profiler-api/utils/http.php';
require $_SERVER['DOCUMENT_ROOT'] . '/profiler-api/models/grade.php';

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
        $db = new Db('SELECT * FROM `grades`');
        $response = array();
        $db->execute();
        $records = $db->fetchAll();
        $rowCount = count($records);
        if ($rowCount > 0) {
            foreach ($records as &$record) {
                $value = new Grade($record);
                array_push($response, $value);
            }
            Http::ReturnSuccess($response);
        } else {      
            Http::ReturnError(404, array('message' => 'No records.'));
        }     
    } else {//select * from grades join courses on grades.id = courses.id
        //WHERE studentId = :id
        $db = new Db('SELECT * FROM `grades` AS grade JOIN `courses` AS course ON grade.id = course.id');
        $db->bindParam(':id', $id);
        $db->execute();
        $records = $db->fetchAll();
        $rowCount = count($records);
        if ($rowCount === 0) {
            Http::ReturnError(404, array('message' => 'Object not found.'));
        } else {
            $record = $records[0];
            $value = new Grade($record);
            Http::ReturnSuccess($value);
        }
    }
} catch (PDOException $pe) {
    Db::ReturnDbError($pe);
} catch (Exception $e) {
    Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
}