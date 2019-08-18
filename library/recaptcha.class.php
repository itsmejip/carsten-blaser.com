<?php
namespace Jip\Library;

class Recaptcha {
		
	const GOOGLE_VALIDATION_PAGE = "https://www.google.com/recaptcha/api/siteverify";

	private static $keyArray = null;

	private static $identifier = null;

	public function getIdenitifier() {
		if (!is_null(self::$identifier)) {
			return self::$identifier;
		}
			
		$domainName = $_SERVER["SERVER_NAME"];
		$foundIdentifier = null;
		foreach(self::$keyArray as $identifier => $entry) {
			foreach($entry["domain_patterns"] as $domain) {
				if ($domain == $domainName) {
					$foundIdentifier = $identifier;
					break;
				}
			}
		}
		self::$identifier =  $foundIdentifier;
		return $foundIdentifier;
	}

	public function __construct($file) {
		$this->load($file);
	}

	private function load($file) {
		if (!is_null(self::$keyArray))
			return;

		if (!file_exists($file)) {
			throw new \Exception("File does not exist: '$file'");
		}

		self::$keyArray = json_decode(file_get_contents($file),true);
	}
	
	private function getSecretKey($identifier = null) {
		if(is_null($identifier)) {
			$identifier = $this->getIdenitifier();
		}

		if (self::$keyArray[$identifier]) {
			return self::$keyArray[$identifier]["secretkey"];
		}
		return null;
	}
	
	public function getSiteKey($identifier = null) {
		if(is_null($identifier)) {
			$identifier = $this->getIdenitifier();
		}
		
		if (self::$keyArray[$identifier]) {
			return self::$keyArray[$identifier]["sitekey"];
		}
		return null;
	}
	
	public function getJsonResponse($captchaResponse, $identifier = null) {
		if(is_null($identifier)) {
			$identifier = $this->getIdenitifier();
		}

		$remoteip=$_SERVER['REMOTE_ADDR'];
		$secretKey = $this->getSecretKey($identifier);

		if ($secretKey && $captchaResponse) {
			$content = file_get_contents(self::GOOGLE_VALIDATION_PAGE . "?secret=$secretKey&response=$captchaResponse&remoteip=$remoteip");
			return json_decode($content, TRUE);
		}
		return null; 
	}
}

?>