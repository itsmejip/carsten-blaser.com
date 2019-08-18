<?php
namespace Jip\Library;

class Session {

    /**
     * CONSTS
     */
    const SESSION_LANG_VARIABLE = "session-lang";
    const SESSION_CSRF_TOKEN_VARIABLE = "session-csrf-token";

    const DEFAULT_LANG_INDEX = 1;

    /**
     * STATIC
     */
    private static $instance;

    private static $defaultLanguage = null;

    public static function setDefaultLanguage($lang) {
        if (in_array($lang, SUPPORTED_LANGUAGES)) {
            self::$defaultLanguage = $lang;
        } 
    }

    private static function getDefaultLanguage() {
        return !is_null(self::$defaultLanguage) ? self::$defaultLanguage : SUPPORTED_LANGUAGES[self::DEFAULT_LANG_INDEX];
    }

    /**
     * @return Session session
     */
    public static function get() {
        if (is_null(self::$instance)) {
            self::$instance = new Session();    
            self::$instance->load();
        }
        return self::$instance;
    }

    public static function save() {
        $_SESSION[self::SESSION_LANG_VARIABLE] = self::$instance->lang;
        $_SESSION[self::SESSION_CSRF_TOKEN_VARIABLE] = serialize(self::$instance->csrfToken);

        return $session;
    }

    private function __construct() {}

    /**
     * Page language
     */
    private $lang;

    private $csrfToken;

    

	public function getLang() {
		return $this->lang;
	}

	public function setLang($lang) {
        if (in_array($lang, SUPPORTED_LANGUAGES)) {
            $this->lang = $lang;
        }
		return $this;
    }

    public function getCsrfToken() {
		return $this->csrfToken;
	}

	public function setCsrfToken($csrfToken) {
		$this->csrfToken = $csrfToken;
		return $this;
	}

    public function load() {
        $this->setLang(isset($_SESSION[self::SESSION_LANG_VARIABLE]) ? $_SESSION[self::SESSION_LANG_VARIABLE] : self::getDefaultLanguage());

        if (isset($_SESSION[self::SESSION_CSRF_TOKEN_VARIABLE])) {
            $this->setCsrfToken(unserialize($_SESSION[self::SESSION_CSRF_TOKEN_VARIABLE]));
        } else {
            $this->setCsrfToken(CsrfToken::create());
        }
    }
}

?>