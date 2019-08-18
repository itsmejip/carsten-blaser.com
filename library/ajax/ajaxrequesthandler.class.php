<?php

namespace Jip\Library\Ajax;

use Jip\Library\CsrfToken;

class AjaxRequestHandler {

    public static function createJsonError($error_identifier, $error_msg = null, $error_url = null, $err_details = null) {
		if (is_null($error_identifier))
			return json_encode(array());
		
		$err = array(
			"error" => 	$error_identifier,
			"error_description" => 	$error_msg
		);
		
		if (!is_null($error_url)) 
			$err["url"] = $error_url;
		
		if (!is_null($err_details)) 
			$err["details"] = $err_details;
		
		return json_encode($err);
	}
	
	const KEY_PARAMETER = "key";
	const JSON_METHOD_TOKEN = "method";
	const JSON_PARAMETERS_TOKEN = "parameters";
	const JSON_FACTORY_CLASS_TOKEN = "factory_class";
	const JSON_OBJECT_ONLY = "json_object";
	const JSON_SCHEME = "json_scheme";
	const JSON_IGNORE_CSRF = "ignore_csrf";
	
	/**
	 * Request catalogue
	 * @var mixed[] 
	 */
	private $requestLibrary;
	
	/**
	 * Request keys of the library
	 * @var string[]
	 */
	private $requestKeys;
	
	/**
	 * 
	 * @param string $filename Filename of the library 
	 * @throws \Exception If the library is not found
	 */
	public function __construct($filename) {
		
		if (!file_exists($filename))
			throw new \Exception("AjaxManager - No request library found: " . $filename);

		$this->requestLibrary = json_decode(file_get_contents($filename), true);
		$this->requestKeys = array_keys($this->requestLibrary);
	}
	
	/**
	 * Handles the request
	 */
	public function handleRequest(CsrfToken $token = null) {
		$output = isset($_POST[self::KEY_PARAMETER]) || isset($_GET[self::KEY_PARAMETER]);
		$key_parameter = isset($_POST[self::KEY_PARAMETER]) ?	$_POST[self::KEY_PARAMETER] : $_GET[self::KEY_PARAMETER];	

		$parameterError = array();
		/**
		 * Check CSRF Token
		 */
		if ($output && !is_null($token) && !$this->ignoreCsRf($key_parameter)) {
			$headers = getallheaders();
			$output = (isset($headers['Csrf-Token']));
			if ($output) {
				$output = ($token->getToken() == $headers['Csrf-Token']);
			}
						
			if (!$output) {
				$parameterError[] = "NO_PERMISSION_TOKEN";
			}
		} 

		/* We need to check if the request key exists */
		$method = null;
		
		if ($output) {
			$method = strtolower($_SERVER["REQUEST_METHOD"]);
			//$key_parameter = isset($_POST[self::KEY_PARAMETER]) ?	$_POST[self::KEY_PARAMETER] : $_GET[self::KEY_PARAMETER];	
			$output = $this->existsRequestKey($key_parameter);

			if (!$output)
				$parameterError[] = "NO_KEY_PARAMETER_SET";
		}
		/* Check if the correct method is used */
		if ($output) {
			$output = ($method === strtolower($this->getMethod($key_parameter)));
			if (!$output)
				$parameterError[] = "WRONG_METHOD_USED";
		}
		
		/* Now check if every needed parameter is there */
		$factoryParam = array();
		if ($output) {
			$parameters = $this->getParameters($key_parameter);
			if (!is_null($parameters)) {
				foreach ($parameters as $parameter) {
					$checked = false;
					$exists = false;
					$value = null;
					$optional = ($parameter["optional"] == 1);
					if ($method === "get") {
						$exists = isset($_GET[$parameter["name"]]);
						if (!is_array($_GET[$parameter["name"]]))
							$value = strval($_GET[$parameter["name"]]);
						else 
							$value = $_GET[$parameter["name"]];
					} else {
						$exists = isset($_POST[$parameter["name"]]);
						if (!is_array($_POST[$parameter["name"]]))
							$value = strval($_POST[$parameter["name"]]);
						else 
							$value = $_POST[$parameter["name"]];
					}
					
					if ($exists) {
						$checked = $this->checkParameter($parameter, $value);
					}
					
					if ((!$checked && $exists) || (!$exists && !$optional)) {
						$output = false;
						$parameterError[]= "WRONG_PARAMETER_VALUE: " . $parameter["name"];
					} else if ($exists && $checked) {
						$factoryParam[$parameter["name"]] = htmlspecialchars($value);
					}
				}
			}
		}
		
		
		// Now build the instance
		if ($output) {
			$class =  strval($this->getInstanceClass($key_parameter));
			$instance = new $class;
			$instance->setParameter($factoryParam);
			$instance->setKey($key_parameter);
			$instance->displayOutput();
		} else {
			header('Content-Type: application/json');
			http_response_code(400);
			echo self::createJsonError("NOT_ABLE_TO_EXECUTE_REQUEST", null, null, $parameterError);
		}
	}
	
	/**
	 * Check if key in library exists
	 * 
	 * @param string $parameter Key name
	 */
	private function existsRequestKey($parameter) {
		return in_array($parameter, $this->requestKeys, true);
	}
	
	/**
	 * Get the method which method ("post" or "get") is used for the request 
	 * 
	 * @param string $key Key of request
	 */
	private function getMethod($key) {
		return $this->requestLibrary[$key][self::JSON_METHOD_TOKEN];
	}
	
	/**
	 * Get the parameter definition of the request
	 * 
	 * @param string $key Key of the request
	 */
	private function getParameters($key) {
		return $this->requestLibrary[$key][self::JSON_PARAMETERS_TOKEN];
	}

	private function ignoreCsRf($key) {
		return !is_null($this->requestLibrary[$key]) && is_bool($this->requestLibrary[$key][self::JSON_IGNORE_CSRF]) && $this->requestLibrary[$key][self::JSON_IGNORE_CSRF];
	}
	
	/**
	 * Get the instance class of the request
	 * 
	 * @param string $key Key of the request
	 */
	private function getInstanceClass($key) {
		return $this->requestLibrary[$key][self::JSON_FACTORY_CLASS_TOKEN];
	}
	
	/**
	 * Checks if request is a json request .
	 * 
	 * This means that there is a "json" parameter which holds all needed information
	 * of the request
	 * 
	 * @param string $key Key of the request
	 */
	private function isJsonObject($key) {
		$value = isset($this->requestLibrary[$key][self::JSON_OBJECT_ONLY]) && $this->requestLibrary[$key][self::JSON_OBJECT_ONLY]; 
		return (is_bool($value) ? $value : false);
	}
	
	/**
	 * Returns the json scheme definition of an request from library
	 * @param string $key Key of the request
	 */
	private function getJsonScheme($key) {
		return $this->requestLibrary[$key][self::JSON_SCHEME];
	}
	
	/**
	 * Checks if the value of a parameter fits to its defined scheme.
	 *  
	 * @param string $scheme Parameter scheme
	 * @param string $parameter_value Parameter value
	 */
	private function checkParameter($scheme, $parameter_value) {
		$canParse = false;
		 if ($scheme["type"] === "array") {
			$arrType = $scheme["array_type"];
			$canParse = !is_null($arrType) && is_array($parameter_value);
			if ($canParse) {
				foreach ($parameter_value as $value) {
					$canParse = $this->checkParameterValue($arrType, $value, $scheme["optional"]);
					if (!canParse)
						break;
				}
			}
		} else {
			$canParse = $this->checkParameterValue($scheme["type"], $parameter_value, $scheme["optional"]);
		}
		return $canParse;
	}
	
	/**
	 * Helper function to check parameter value 
	 * @param string $valueType Type of parameter
	 * @param string $parameter_value Value of the parameter
	 * @param number $optional 1 = if optional, 0 = not
	 */
	private function checkParameterValue($valueType, $parameter_value, $optional = 0) {
		$canParse = false;
		if ($valueType === "string") {
			$canParse = strlen($parameter_value) > 0 || $optional == 1;
		} else if ($valueType === "int") {
			$int = intval($parameter_value);
			$canParse =(strval($int) === $parameter_value);
		} else if ($valueType === "float") {
			$float = floatval($parameter_value);
			$canParse =(strval($float) === $parameter_value);
		} else if ($valueType === "bool") {
			$int = intval($parameter_value);
			$canParse =(strval($int) === $parameter_value && ($int === 0 || $int === 1));
		} else if ($valueType === "datetime") {
			$canParse = (bool) strtotime($parameter_value);
		}
			
		return $canParse;
    }
}

?>