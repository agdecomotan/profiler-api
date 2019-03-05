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
        $db = new Db('SELECT * FROM `profiles` WHERE id = :id LIMIT 1');     
        $db->bindParam(':id', property_exists($input, 'id') ? $input->id : 0);

        if ($db->execute() === 0) {
            Http::ReturnError(404, array('message' => 'Object not found.'));
        } else {
            $db = new Db('UPDATE `profiles` SET dateCreated = :dateCreated, 
            stageOneDate = :stageOneDate, 
            stageTwoDate = :stageTwoDate, 
            stageOneResult = :stageOneResult, 
            stageTwoResult = :stageTwoResult, 
            finalResult = :finalResult, 
            status = :status, 
            studentId = :studentId, 
            userId = :userId
            WHERE id = :id');

            $db->bindParam(':id', property_exists($input, 'id') ? $input->id : 0);
            $db->bindParam(':dateCreated', property_exists($input, 'dateCreated') ? $input->dateCreated : null);
            $db->bindParam(':stageOneDate', property_exists($input, 'stageOneDate') ? $input->stageOneDate : null);
            $db->bindParam(':stageTwoDate', property_exists($input, 'stageTwoDate') ? $input->stageTwoDate : null);
            $db->bindParam(':stageOneResult', property_exists($input, 'stageOneResult') ? $input->stageOneResult : null);    
            $db->bindParam(':stageTwoResult', property_exists($input, 'stageTwoResult') ? $input->stageTwoResult : null);   
            $db->bindParam(':finalResult', property_exists($input, 'finalResult') ? $input->finalResult : null);  
            $db->bindParam(':status', property_exists($input, 'status') ? $input->status : null);   
            $db->bindParam(':studentId', property_exists($input, 'studentId') ? $input->studentId : null);     
            $db->bindParam(':userId', property_exists($input, 'userId') ? $input->userId : null);        
       
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