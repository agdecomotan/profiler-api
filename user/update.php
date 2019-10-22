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
        $db = new Db('SELECT * FROM `users` WHERE id = :id LIMIT 1');     
        $db->bindParam(':id', property_exists($input, 'id') ? $input->id : 0);

        if ($db->execute() === 0) {
            Http::ReturnError(404, array('message' => 'Object not found.'));
        } else {
            $db = new Db('UPDATE `users` SET 
            firstName = :firstName, 
            lastName = :lastName, 
            position = :position, 
            email = :email,
            username = :username, 
            password = :password
            WHERE id = :id');

            $db->bindParam(':id', property_exists($input, 'id') ? $input->id : 0);
          
            $db->bindParam(':firstName', property_exists($input, 'firstName') ? $input->firstName : null);
            $db->bindParam(':lastName', property_exists($input, 'lastName') ? $input->lastName : null);
            $db->bindParam(':position', property_exists($input, 'position') ? $input->position : null);    
            $db->bindParam(':username', property_exists($input, 'username') ? $input->username : null);     
            $db->bindParam(':password', property_exists($input, 'password') ? $input->password : null);
            $db->bindParam(':email', property_exists($input, 'email') ? $input->email : null);     
       
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