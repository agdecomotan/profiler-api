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
    $trackValue = json_decode($value->finalResult1, true);
    $trackResult = $trackValue['result'];
    $trackTitle = '';

    if($trackResult === 'SD'){
      $trackTitle = 'Software Development';
    } else if($trackResult === 'DS'){
      $trackTitle = 'Distributed Systems';
    } else if($trackResult === 'MS'){
      $trackTitle = 'Multimedia Studies';
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
  	$mail->Subject = 'Track Profiling Result';   	
  	$message = '<p>Dear '.$value->studentFirstName.',</p><br/><p>Here is the result of the track profiling: '.$trackTitle.'.</p><br/><p>Regards,</p><p>College of Information and Communications Technology</p><p>West Visayas State University</p>'; 
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