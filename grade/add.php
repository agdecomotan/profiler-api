<?php
namespace AGD\Profiler;

require $_SERVER['DOCUMENT_ROOT'] . '/profiler-api/utils/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/profiler-api/utils/http.php';

use Exception;
use PDOException;

Http::HandleOption();
Http::SetDefaultHeaders('POST');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Http::ReturnError(405, array('message' => 'Request method is not allowed.'));
    return;
}

$input = json_decode(file_get_contents("php://input"));
$datecreated = date('Y-m-d H:i:s');

if (is_null($input)) {
    Http::ReturnError(400, array('message' => 'Object details are empty.'));
} else {
    try {
        $db = new Db('INSERT INTO `grades`(courseId, studentId, value, term, year) 
                    VALUES(:courseId, :studentId, :value, :term, :year)');
        
        $db->bindParam(':courseId', property_exists($input, 'courseId') ? $input->courseId : null);
        $db->bindParam(':studentId', property_exists($input, 'studentId') ? $input->studentId : null);
        $db->bindParam(':value', property_exists($input, 'value') ? $input->value : null);
        $db->bindParam(':term', property_exists($input, 'term') ? $input->term : null);    
        $db->bindParam(':year', property_exists($input, 'year') ? $input->year : null);   
        
        $db->execute();
        $db->commit();
        $id = $db->lastInsertId();
        Http::ReturnSuccess(array('message' => 'Object created.', 'id' => $id));
    } catch (PDOException $pe) {
        Db::ReturnDbError($pe);
    } catch (Exception $e) {
        Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
    }
}