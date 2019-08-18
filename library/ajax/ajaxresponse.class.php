<?php
namespace Jip\Library\Ajax;

/**
 * A abstract class which need to be inherited by every response instance to an ajax request
 *  
 * @author jip
 * @version 1.0.0
 *
 */
abstract class AjaxResponse {
	/**
	 * This includes all parameters of the request 
	 * @var string[] 
	 */
	protected $parameter;
	
	/**
	 * This holds the key parameter (identifier) of the request
	 * @var string
	 */
	protected $key;
	
	/**
	 * Returns all parameters of the request
	 * @return string[] 
	 */
	public function getParameter() {
		return $this->parameter;
	}
	
	/**
	 * Sets an array of all parameters of the corresponding request
	 * @param string[] $parameter
	 */
	public function setParameter($parameter) {
		$this->parameter = $parameter;
		return $this;
	}
	
	/**
	 * Sets the key parameter of the request
	 * @param string $key
	 */
	public function setKey($key) {
		$this->key = $key;
		return $this;
	}
	
	/**
	 * Returns the key parameter of the request
	 * @return string
	 */
	public function getKey() {
		return $this->key;
	}
	
	/**
	 * This method will be triggered after successfully checking the request
	 */
	public abstract function displayOutput(); 
}