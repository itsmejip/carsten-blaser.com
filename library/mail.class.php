<?php
namespace Jip\Library;

use PHPMailer\PHPMailer;

class Mail extends PHPMailer {

	/**
	 * Per default is the mail "system mail" email type
	 */
	private $emailType = 1;

	/**
	 * If a template is used to create the email the name of the template is saved here.
	 */
	private $usedTemplate;

	/**
	 * Language the email is written in
	 */
	private $usedLangauage = 'en';

	public function getUsedTemplate() {
		return $this->usedTemplate;
	}

	public function setUsedTemplate($usedTemplate) {
		$this->usedTemplate = $usedTemplate;
	}

	public function getUsedLangauage() {
		return $this->usedLangauage;
	}

	public function setUsedLangauage($usedLangauage) {
		$this->usedLangauage = $usedLangauage;
		return $this;
	}

	public function getEmailType() {
		return $this->emailType;
	}
		
	public function __construct($emailType = MailType::SYSTEM) {
		parent::__construct(true);
		$this->emailType = $emailType;
	}
	
	public function replacePlaceholders($replacements) {
		$template = $this->Body;
		$this->Body = preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements)
		{
			return $replacements[$matches[1]];
		}, $template);
	}
		
	public static function create($sender, $recepients) {
		$mail = new Mail();
		
		if (is_array($sender)) 
			$mail->setFROM($sender[0], $sender[1]);
		else 
			$mail->setFROM($sender);
		if (is_array($recepients)) {
			foreach($recepients as $rec) {
				$mail->addAddress($rec);
			}
		} else {
			$mail->addAddress($recepients);
		}

		$mail->CharSet ='UTF-8';
		$mail->Encoding = 'base64';
		$mail->isSendmail();
		$mail->XMailer = 'JMS - Jip Mailing System 1.0.1';
		
		return $mail;
	}
	
	public function send() {
		return parent::send();
	}
}

?>