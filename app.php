<?php
    INCLUDE_ONCE "config.php";
    INCLUDE_ONCE "utils.php";
    INCLUDE_ONCE LIBRARIES_PATH . "classloader.class.php";

    $classLoader = new ClassLoader(ROOT_PATH);
    $classLoader->register();
    
    use Jip\Library\Session;



    if (DEBUG_MODE) {
        ini_set('display_errors', 1);
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
    } else  {
        ini_set('display_errors', 0);
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
    }

    session_start();

    /**
     * Set default language to german if ending of domain is .de and it is not set already
     */
    if (preg_match("/.*\.de$/", $_SERVER["SERVER_NAME"])) {
        Session::setDefaultLanguage("de");
    } else {
        Session::setDefaultLanguage("en");
    }   
    

    Session::get();
?>