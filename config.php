<?php
 /**
     * Flag for displaying errors on page
     * IMPORTANT: Set to false if live
     */
    define("DEBUG_MODE", false);

    /**
     * Supported languages
     */
    define("SUPPORTED_LANGUAGES", array("de", "en"));

    /**
     * Root path
     */
    define("ROOT_PATH" , dirname(__FILE__). '/');

    /**
     * Other paths
     */
    define("LIBRARIES_PATH" , ROOT_PATH . 'library/');

    define("VIEW_PATH" , ROOT_PATH . 'view/');

    define("VIEW_SECTIONS_PATH" , ROOT_PATH . 'view/sections/');

    define ("HTML_IMAGE_PATH", ROOT_PATH . 'html/img/');

    define ("HTML_JS_PATH", ROOT_PATH . 'html/js/');

    define ("HTML_CSS_PATH", ROOT_PATH . 'html/css/');

    define ("RESOURCES_PATH", ROOT_PATH . 'resources/');

    define ("RESOURCES_PAGE_PATH", RESOURCES_PATH . 'page/');

    define ("RESOURCES_DATA_PATH", RESOURCES_PATH . 'data/');

    define ("RESOURCES_LOCKS_PATH", RESOURCES_PATH . 'locks/');

    define ("LANG_PATH", RESOURCES_PATH . 'lang/');

    /**
     * Portfolio data file
     */
    define ("DATA_FILE_PORTFOLIO", RESOURCES_DATA_PATH . "index.portfolio.data.json");

    /**
     * Recaptcha data file
     */
    define ("DATA_FILE_RECAPTCHA", RESOURCES_DATA_PATH . "recaptcha.json");

    /**
     * Email addresses
     */
    define("CONTACT_FORM_SENDER", array("contact-form@carsten-blaser.com", "HP - Contact Form"));

    define("CONTACT_FORM_RECEIVER", "jip@carsten-blaser.com");
?>