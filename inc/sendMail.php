<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
	//Server settings
	$mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
	$mail->isSMTP(); //Send using SMTP
	$mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
	$mail->SMTPAuth = true; //Enable SMTP authentication
	$mail->Username = 'mack64948@gmail.com'; //SMTP username
	$mail->Password = '2jQ!rpp&!!jdf'; //SMTP password
	$mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
	$mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

	//Recipients
	$mail->setFrom($mailFrom, $name);
	$mail->addAddress('alexmack235711@protonmail.com', 'Independent Claws Admin'); //Add a recipient

    $content = $message;
     if ($subscribe == "on") {
         $content .= "I would like to subscribe.";
    } else {
         $content .= "I am not interested in subscribing.";
    }

    $mail->isHTML(true); //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body($content);
    $mail->AltBody($content);
    $mail->send()
	
	$mail->send();
	echo 'Message has been sent';
} catch (Exception $e) {
	echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}