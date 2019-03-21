<?php 
namespace AGD\Profiler;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'] . '/profiler-api/utils/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/profiler-api/utils/http.php';
require $_SERVER['DOCUMENT_ROOT'] . '/profiler-api/models/profile.php';
require $_SERVER['DOCUMENT_ROOT'] . '/profiler-api/utils/PHPMailer/src/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/profiler-api/utils/PHPMailer/src/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/profiler-api/utils/PHPMailer/src/SMTP.php';  


Http::SetDefaultHeaders('GET');
$id = '';

if (array_key_exists('id', $_GET)) {
    $id = $_GET['id'];
}

try {  
  	$db = new Db('SELECT * FROM profiles g JOIN students c ON g.studentId = c.id WHERE g.studentId = :id LIMIT 1');
  	$db->bindParam(':id', $id);
  	$db->execute();
  	$records = $db->fetchAll();
  	$rowCount = count($records);
  	if ($rowCount > 0) {            
  	    $record = $records[0];
  	    $value = new Profile($record);            
  	}
  	Http::ReturnSuccess($value);

  	$mail = new PHPMailer(true);
  	$mail->isSMTP();  
  	$mail->SMTPDebug = 0; 
  	$mail->Host = 'smtp.gmail.com';
  	$mail->Port = 587; 
  	$mail->SMTPSecure = 'tls'; 
  	$mail->SMTPAuth = true; 
  	$mail->Username = "agdecomotan@up.edu.ph"; 
  	$mail->Password = "fnggtebfexgawxyg"; 
  	$mail->setFrom($mail->Username); 
  	$mail->addAddress($value->email); 
  	$mail->Subject = 'Your Account Registration';   	
  	$message = '<p>Dear '.$value->studentFirstName.',</p><p>Here is the result of the track profiling: '.$value->finalResult.'</p>'; 
  	$mail->msgHTML($message); 
  	$mail->AltBody = strip_tags($message); 
  	if(!$mail->send())
  	{
     	$formMsg = "Message could not be sent.";
     	exit;
  	}
  	$formMsg = 'Registration successful. Please check your email.';

} catch (phpmailerException $e) {
  $formMsg = $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
  $formMsg = $e->getMessage(); 
}
?>