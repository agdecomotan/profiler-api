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
if (is_null($input)) {
    Http::ReturnError(400, array('message' => 'Object details are empty.'));
} else {
    try {
        $db = new Db('SELECT * FROM `grades` WHERE id = :id LIMIT 1');     
        $db->bindParam(':id', property_exists($input, 'id') ? $input->id : 0);

        if ($db->execute() === 0) {
            Http::ReturnError(404, array('message' => 'Object not found.'));
        } else {
            $db = new Db('UPDATE `grades` SET courseId = :courseId, 
            studentId = :studentId, 
            value = :value, 
            term = :term, 
            year = :year
            WHERE id = :id');

            $db->bindParam(':id', property_exists($input, 'id') ? $input->id : 0);
            $db->bindParam(':courseId', property_exists($input, 'courseId') ? $input->courseId : null);
            $db->bindParam(':studentId', property_exists($input, 'studentId') ? $input->studentId : null);
            $db->bindParam(':value', property_exists($input, 'value') ? $input->value : null);
            $db->bindParam(':term', property_exists($input, 'term') ? $input->term : null);    
            $db->bindParam(':year', property_exists($input, 'year') ? $input->year : null);   
       
            $db->execute();     
            $db->commit();
    
            Http::ReturnSuccess(array('message' => 'Object updated.', 'id' => $input->id));
        }
    } catch (PDOException $pe) {
        Db::ReturnDbError($pe);
    } catch (Exception $e) {
        Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
    }
}