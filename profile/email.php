<?php 
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require $_SERVER['DOCUMENT_ROOT'] . '/profiler-api/utils/PHPMailer/src/Exception.php';
  require $_SERVER['DOCUMENT_ROOT'] . '/profiler-api/utils/PHPMailer/src/PHPMailer.php';
  require $_SERVER['DOCUMENT_ROOT'] . '/profiler-api/utils/PHPMailer/src/SMTP.php';  


  try{        
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
      $mail->addAddress("agdecomotan@yahoo.com"); 
      $mail->Subject = 'Your Account Registration'; 
      $message = '<p>Dear Test,</p><p>Thank you for registering to my website. Have a great day!</p>'; 
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