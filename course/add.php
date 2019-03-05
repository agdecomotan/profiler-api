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
        $db = new Db('INSERT INTO `courses`(courseNumber, title, specialization, credit, active) 
                    VALUES(:courseNumber, :title, :specialization, :credit, :active)');
        
        $db->bindParam(':courseNumber', property_exists($input, 'courseNumber') ? $input->courseNumber : null);
        $db->bindParam(':title', property_exists($input, 'title') ? $input->title : null);
        $db->bindParam(':specialization', property_exists($input, 'specialization') ? $input->specialization : null);
        $db->bindParam(':credit', property_exists($input, 'credit') ? $input->credit : null);    
        $db->bindParam(':active', property_exists($input, 'active') ? $input->active : null);   
        
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