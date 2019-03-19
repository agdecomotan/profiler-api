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
        $db = new Db('SELECT * FROM profiles g JOIN students c ON g.studentId = c.id WHERE g.studentId = :studentId LIMIT 1');
        $db->bindParam(':studentId', $input->studentId);
        $db->execute();
        $records = $db->fetchAll();
        $rowCount = count($records);
        if ($rowCount === 0) { 
            $db = new Db('INSERT INTO `profiles`(dateCreated, initialDate, finalDate, initialResult, finalResult, status, studentId, userId, sdExam, dsExam, msExam, sdInterview, dsInterview, msInterview) 
                        VALUES(:dateCreated, :initialDate, :finalDate, :initialResult, :finalResult, :status, :studentId, :userId, :sdExam, :dsExam, :msExam, :sdInterview, :dsInterview, :msInterview)');
            
            $db->bindParam(':dateCreated', $datecreated);
            $db->bindParam(':initialDate', property_exists($input, 'initialDate') ? $input->initialDate : null);
            $db->bindParam(':finalDate', property_exists($input, 'finalDate') ? $input->finalDate : null);
            $db->bindParam(':initialResult', property_exists($input, 'initialResult') ? $input->initialResult : null);    
            $db->bindParam(':finalResult', property_exists($input, 'finalResult') ? $input->finalResult : null);  
            $db->bindParam(':status', property_exists($input, 'status') ? $input->status : null);  
            $db->bindParam(':studentId', property_exists($input, 'studentId') ? $input->studentId : null);   
            $db->bindParam(':userId', property_exists($input, 'userId') ? $input->userId : null);     
            $db->bindParam(':sdExam', property_exists($input, 'sdExam') ? $input->sdExam : null);         
            $db->bindParam(':dsExam', property_exists($input, 'dsExam') ? $input->dsExam : null);         
            $db->bindParam(':msExam', property_exists($input, 'msExam') ? $input->msExam : null);         
            $db->bindParam(':sdInterview', property_exists($input, 'sdInterview') ? $input->sdInterview : null); 
            $db->bindParam(':dsInterview', property_exists($input, 'dsInterview') ? $input->dsInterview : null);            
            $db->bindParam(':msInterview', property_exists($input, 'msInterview') ? $input->msInterview : null);             
           
            
            $db->execute();
            $db->commit();
            $id = $db->lastInsertId();
            Http::ReturnSuccess(array('message' => 'Object created.', 'id' => $id));
        } else {
            Http::ReturnSuccess(array('message' => 'Object exists.', 'id' => $studentId));
        }
    } catch (PDOException $pe) {
        Db::ReturnDbError($pe);
    } catch (Exception $e) {
        Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
    }
}