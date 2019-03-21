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

$studentNumber = '';
if (array_key_exists('studentNumber', $_GET)) {
    $studentNumber = $_GET['studentNumber'];
}

if (is_null($input)) {
    Http::ReturnError(400, array('message' => 'Object details are empty.'));
} else {
    try {        
        $db = new Db('SELECT * FROM `students` WHERE studentNumber = :studentNumber LIMIT 1');
        $db->bindParam(':studentNumber', $studentNumber);
        $db->execute();
        $records = $db->fetchAll();
        $rowCount = count($records);
        if ($rowCount === 0) { 
            $db = new Db('INSERT INTO `students`(studentNumber, firstName, lastName, yearLevel, program, email, datecreated) 
                        VALUES(:studentNumber, :firstName, :lastName, :yearLevel, :program, :email, :datecreated)');
            
            $db->bindParam(':studentNumber', property_exists($input, 'studentNumber') ? $input->studentNumber : null);
            $db->bindParam(':firstName', property_exists($input, 'firstName') ? $input->firstName : null);
            $db->bindParam(':lastName', property_exists($input, 'lastName') ? $input->lastName : null);
            $db->bindParam(':yearLevel', property_exists($input, 'yearLevel') ? $input->yearLevel : null);    
            $db->bindParam(':program', property_exists($input, 'program') ? $input->program : null);   
            $db->bindParam(':email', property_exists($input, 'email') ? $input->email : null);     
            $db->bindParam(':datecreated', $datecreated);
            
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