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
        $db = new Db('INSERT INTO `users`(firstName, lastName, position, username, email, password) 
                    VALUES(:studentNumber, :firstName, :lastName, :position, :username, :email, :password)');
        
        $db->bindParam(':firstName', property_exists($input, 'firstName') ? $input->firstName : null);
        $db->bindParam(':lastName', property_exists($input, 'lastName') ? $input->lastName : null);
        $db->bindParam(':position', property_exists($input, 'position') ? $input->position : null);    
        $db->bindParam(':username', property_exists($input, 'username') ? $input->username : null);   
        $db->bindParam(':email', property_exists($input, 'email') ? $input->email : null);  
        $db->bindParam(':password', property_exists($input, 'password') ? $input->password : null);   
        
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