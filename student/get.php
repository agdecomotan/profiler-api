<?php
namespace AGD\Profiler;

require $_SERVER['DOCUMENT_ROOT'] . '/profiler-api/utils/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/profiler-api/utils/http.php';
require $_SERVER['DOCUMENT_ROOT'] . '/profiler-api/models/student.php';

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
        $response = array();

        if ($db->execute() > 0) {
            $records = $db->fetchAll();
            foreach ($records as &$record) {
                $value = new Student($record);
                array_push($response, $value);
            }
        }

        $record = $db->fetchAll();
        echo json_encode($record);

        Http::ReturnSuccess($response);
    } else {
        $db = new Db('SELECT * FROM `students` WHERE id = :id LIMIT 1');
        $db->bindParam(':id', $id);
        if ($db->execute() === 0) {
            Http::ReturnError(404, array('message' => 'Object not found.'));
        } else {
            $record = $db->fetchAll()[0];
            $value = new Student($record);
            Http::ReturnSuccess($value);
        }
    }
} catch (PDOException $pe) {
    Db::ReturnDbError($pe);
} catch (Exception $e) {
    Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
}