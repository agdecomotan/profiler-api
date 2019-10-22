<?php
namespace AGD\Profiler;

require $_SERVER['DOCUMENT_ROOT'] . '/utils/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/utils/http.php';

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
        $db = new Db('SELECT * FROM `profiles` WHERE studentId = :studentId LIMIT 1');     
        $db->bindParam(':studentId', property_exists($input, 'studentId') ? $input->studentId : 0);

        if ($db->execute() === 0) {
            Http::ReturnError(404, array('message' => 'Object not found.'));
        } else {
            $db = new Db('UPDATE `profiles` SET dateCreated = :dateCreated, 
            initialDate = :initialDate, 
            finalDate = :finalDate, 
            initialResultRank = :initialResultRank,
            initialResult1 = :initialResult1,
            initialResult2 = :initialResult2,
            initialResult3 = :initialResult3, 
            finalResultRank = :finalResultRank, 
            studentChoice = :studentChoice, 
            finalResult1 = :finalResult1, 
            finalResult2 = :finalResult2, 
            finalResult3 = :finalResult3, 
            status = :status, 
            studentId = :studentId, 
            userId = :userId, 
            sdExam = :sdExam, 
            dsExam = :dsExam, 
            msExam = :msExam, 
            sdInterview = :sdInterview, 
            dsInterview = :dsInterview,
            msInterview = :msInterview,
            accepted = :accepted
            WHERE studentId = :studentId');

            $db->bindParam(':dateCreated', property_exists($input, 'dateCreated') ? $input->dateCreated : null);
            $db->bindParam(':initialDate', property_exists($input, 'initialDate') ? $input->initialDate : null);
            $db->bindParam(':finalDate', property_exists($input, 'finalDate') ? $input->finalDate : null);
            $db->bindParam(':initialResultRank', property_exists($input, 'initialResultRank') ? $input->initialResultRank : null);
            $db->bindParam(':initialResult1', property_exists($input, 'initialResult1') ? $input->initialResult1 : null);
            $db->bindParam(':initialResult2', property_exists($input, 'initialResult2') ? $input->initialResult2 : null);
            $db->bindParam(':initialResult3', property_exists($input, 'initialResult3') ? $input->initialResult3 : null);    
            $db->bindParam(':finalResultRank', property_exists($input, 'finalResultRank') ? $input->finalResultRank : null);  
            $db->bindParam(':studentChoice', property_exists($input, 'studentChoice') ? $input->studentChoice : null);
            $db->bindParam(':finalResult1', property_exists($input, 'finalResult1') ? $input->finalResult1 : null);
            $db->bindParam(':finalResult2', property_exists($input, 'finalResult2') ? $input->finalResult2 : null);
            $db->bindParam(':finalResult3', property_exists($input, 'finalResult3') ? $input->finalResult3 : null);
            $db->bindParam(':status', property_exists($input, 'status') ? $input->status : null);   
            $db->bindParam(':studentId', property_exists($input, 'studentId') ? $input->studentId : null);     
            $db->bindParam(':userId', property_exists($input, 'userId') ? $input->userId : null);         
            $db->bindParam(':sdExam', property_exists($input, 'sdExam') ? $input->sdExam : null);         
            $db->bindParam(':dsExam', property_exists($input, 'dsExam') ? $input->dsExam : null);            
            $db->bindParam(':msExam', property_exists($input, 'msExam') ? $input->msExam : null);            
            $db->bindParam(':sdInterview', property_exists($input, 'sdInterview') ? $input->sdInterview : null);          
            $db->bindParam(':dsInterview', property_exists($input, 'dsInterview') ? $input->dsInterview : null);       
            $db->bindParam(':msInterview', property_exists($input, 'msInterview') ? $input->msInterview : null);       
            $db->bindParam(':accepted', property_exists($input, 'accepted') ? $input->accepted : null);         
       
            $db->execute();     
            $db->commit();
    
            Http::ReturnSuccess(array('message' => 'Object updated.', 'id' => $input->studentId));
        }
    } catch (PDOException $pe) {
        Db::ReturnDbError($pe);
    } catch (Exception $e) {
        Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
    }
}