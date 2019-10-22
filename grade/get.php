<?php
namespace AGD\Profiler;

require $_SERVER['DOCUMENT_ROOT'] . '/utils/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/utils/http.php';
require $_SERVER['DOCUMENT_ROOT'] . '/models/grade.php';

use Exception;
use PDOException;

Http::SetDefaultHeaders('GET');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    Http::ReturnError(405, array('message' => 'Request method is not allowed.'));
    return;
}

$id = 0;
$specialization = '';

if (array_key_exists('id', $_GET)) {
    $id = intval($_GET['id']);
}

if (array_key_exists('specialization', $_GET)) {
    $specialization = $_GET['specialization'];
}

try {
    if ($specialization !== ''){
        $db = new Db('SELECT * FROM grades g JOIN courses c ON g.courseId = c.id WHERE g.studentId = :id AND c.specialization = :specialization');
        $db->bindParam(':specialization', $specialization);
        $db->bindParam(':id', $id);
        $response = array();
        $db->execute();
        $records = $db->fetchAll();
        $rowCount = count($records);
        if ($rowCount > 0) {
            foreach ($records as &$record) {
                $value = new Grade($record);
                array_push($response, $value);
            }
        } 

        Http::ReturnSuccess($response);   
    } elseif ($id === 0) {
        $db = new Db('SELECT * FROM grades g JOIN courses c ON g.courseId = c.id');
        $response = array();
        $db->execute();
        $records = $db->fetchAll();
        $rowCount = count($records);
        if ($rowCount > 0) {
            foreach ($records as &$record) {
                $value = new Grade($record);
                array_push($response, $value);
            }
        } 

        Http::ReturnSuccess($response);   
    } else {
        $db = new Db('SELECT * FROM grades g JOIN courses c ON g.courseId = c.id WHERE g.studentId = :id');
        $db->bindParam(':id', $id);
        $response = array();
        $db->execute();
        $records = $db->fetchAll();
        $rowCount = count($records);
        if ($rowCount > 0) {
            foreach ($records as &$record) {
                $value = new Grade($record);
                array_push($response, $value);
            }
        } 

        Http::ReturnSuccess($response);   
    }
} catch (PDOException $pe) {
    Db::ReturnDbError($pe);
} catch (Exception $e) {
    Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
}