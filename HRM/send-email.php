<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
if (isset($_POST["sumbit"])) {
require 'C:\xampp\php\HRM\vendor\autoload.php';

    $name = $_POST['name'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    $shiftstart = $_POST['shiftstart'];
    $shiftend = $_POST['shiftend'];}

$mail = new PHPMailer;
$mail->SMTPDebug = 2;


    //Server settings                     //Enable verbose debug output
    $mail->isSMTP();                                           
    $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'ramosjoanne123@gmail.com';                     //SMTP username
    $mail->Password   = 'secret';                               //SMTP password
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('from@example.com', 'Mailer');
    $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
  

     //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'Name:'.$name.'Email'.$email;
 

   if(!$mail->send());{echo 'Message has been not sent';
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
   }
 