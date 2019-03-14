<?php
namespace AGD\Profiler;

require $_SERVER['DOCUMENT_ROOT'] . '/profiler-api/utils/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/profiler-api/utils/http.php';
require $_SERVER['DOCUMENT_ROOT'] . '/profiler-api/models/profile.php';

use Exception;
use PDOException;

Http::SetDefaultHeaders('GET');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    Http::ReturnError(405, array('message' => 'Request method is not allowed.'));
    return;
}

$id = 0;
$status = '';

if (array_key_exists('id', $_GET)) {
    $id = intval($_GET['id']);
}

if (array_key_exists('status', $_GET)) {
    $status = $_GET['status'];
}

try {
     if ($status !== '') {
        $db = new Db('SELECT * FROM profiles g JOIN students c ON g.studentId = c.id WHERE status = :status');
        $response = array();
         $db->bindParam(':status', $status);
        $db->execute();
        $records = $db->fetchAll();
        $rowCount = count($records);
        if ($rowCount > 0) {
            foreach ($records as &$record) {
                $value = new Profile($record);
                array_push($response, $value);
            }
            Http::ReturnSuccess($response);
        } else {      
            Http::ReturnError(404, array('message' => 'No records.'));
        }     
    } elseif ($id === 0) {
        $db = new Db('SELECT * FROM profiles g JOIN students c ON g.studentId = c.id');
        $response = array();
        $db->execute();
        $records = $db->fetchAll();
        $rowCount = count($records);
        if ($rowCount > 0) {
            foreach ($records as &$record) {
                $value = new Profile($record);
                array_push($response, $value);
            }
            Http::ReturnSuccess($response);
        } else {      
            Http::ReturnError(404, array('message' => 'No records.'));
        }     
    } else {
        $db = new Db('SELECT * FROM profiles g JOIN students c ON g.studentId = c.id WHERE id = :id LIMIT 1');
        $db->bindParam(':id', $id);
        $db->execute();
        $records = $db->fetchAll();
        $rowCount = count($records);
        if ($rowCount === 0) {
            Http::ReturnError(404, array('message' => 'Object not found.'));
        } else {
            $record = $records[0];
            $value = new Profile($record);
            Http::ReturnSuccess($value);
        }
    }
} catch (PDOException $pe) {
    Db::ReturnDbError($pe);
} catch (Exception $e) {
    Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
}