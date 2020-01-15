<?php

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Asia/Calcutta');

require 'PHPMailerAutoload.php';

class send_emails
{
	
	public $mail_obj;
	
	public function __construct($parameters = []){
	
		$mail = new PHPMailer();
		$this->mail_obj = $mail;
		
		if(!empty($parameters))
		{				
			$mail->isSMTP();
			
			$mail->SMTPDebug = 0;
			$mail->Debugoutput = 'html';
			
			$mail->Host = "mail.lushshopee.com";
			$mail->SMTPSecure = 'ssl';
			$mail->Port = 465;
			$mail->SMTPAuth = true;
			$mail->Username = "info@lushshopee.com";
			$mail->Password = '0teo?hT]IkM!';
			
			$mail->setFrom('info@lushshopee.com', 'Lush');
			
			$mail->addAddress($parameters['to_mail'], $parameters['name']);
			$mail->Subject = $parameters['subject'];
			$mail->msgHTML($parameters['body']);					
			
		}		
		
	}
	
	public function send_mail(){
		
		if (!$this->mail_obj->send()) {
			return "Mailer Error: " . $mail->ErrorInfo;
		} else {
			return true;
		}		
	}
	
}