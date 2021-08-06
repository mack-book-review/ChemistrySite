<?php

require 'vendor/autoload.php';

$mail = new PHPMailer();

try{
$mail->IsSMTP();
$mail->Mailer = "smtp";

$mail->SMTPDebug = 1;
$mail->SMTPAuth = TRUE;
$mail->SMTPSecure = "tls";
$mail->Port = 587;
$mail->Host = "smtp.gmail.com";
$mail->Username = "mack64948@gmail.com";
$mail->Password = "2jQ!rpp&!!jdf";

$mail->isHTML(true);
$mail->addAddress("alexmack235711@protonmail.com", "Independent Claws Admin");
$mail->addAddress("mack64948@gmail.com@gmail.com", "Independent Claws Admin");

echo "checking form fields...";

	if (empty($name) || empty($mailFrom) || empty($subject) || empty($message) || $subscribe) {

		header("Location: contact.php?mailstatus=error");
	} else {
		echo "form fields valid..sending...";

		$mail->setFrom($mailFrom, $name);

		$mail->Subject = $subject;
		$content = $message;
		if ($subscribe == "on") {
			$content .= "I would like to subscribe.";
		} else {
			$content .= "I am not interested in subscribing.";
		}

		$mail->Body($content);
		$mail->AltBody($content);
		$mail->send()

	
		header("Location: contact.php?mailstatus=success");

		}
	}catch (Exception $e) {
		echo "<div class='alert alert-danger' role='alert'> Error: You must fill out all the information in the form.</div>";
    	echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    	header("Location: contact.php?mailstatus=error");

}

?>