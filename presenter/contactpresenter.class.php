<?php
namespace Jip\Presenter;

use Jip\Model\PortfolioModel;
use Jip\View\DefaultView;
use Jip\Library\Mail;
use Jip\Library\Recaptcha;

class ContactPresenter extends Dto {

    public function __construct($lang) {
        parent::__construct(null, new DefaultView(VIEW_SECTIONS_PATH . 'index.contact.inc.php', $lang));
        
        /**
         * Set view translation module
         */
        $this->view->setTransModuleFile(LANG_PATH . $lang . DIRECTORY_SEPARATOR . "index.contact.json");
    }

    public function canHandleRequest() {
        return !empty($_POST["name"]) && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) && !empty($_POST["message"]);
    }
    
    public function handleRequest() {
        $recaptcha = new Recaptcha(DATA_FILE_RECAPTCHA);
        $resp = $recaptcha->getJsonResponse($_POST["g-recaptcha-response"]);
        $handled = true;
        $errMsg = null;
        
        if (!$resp['success']) {
            $handled = false;
            $errMsg = "RECAPTCHA_ERROR";
        }

        if ($handled) {
            $replacements = array(
                "name" => htmlspecialchars($_POST["name"]),
                "message" => htmlspecialchars($_POST["message"]),
                "email" => htmlspecialchars($_POST["email"]),
                "company" => htmlspecialchars($_POST["company"]),
                "salutation" => htmlspecialchars($_POST["salutation"])
            );

            $mail = Mail::create(CONTACT_FORM_SENDER, CONTACT_FORM_RECEIVER);
            $mail->Body = file_get_contents(RESOURCES_PATH . "contactform.email.tmpl");
            $mail->Subject = "New Contact Form Message";
            $mail->replacePlaceholders($replacements);

            if (!$mail->send()) {
                $handled = false;
                $errMsg = "MAIL_ERROR";
            }
        }
        
        if ($handled) {
            $_POST["name"] = "";
            $_POST["message"] = "";
            $_POST["email"] = "";
            $_POST["company"] = "";
            $_POST["salutation"] = "";
        }

        $_SESSION["SEND_CONTACT_FORM_SUCCESS"] = array("done" => $handled, "error" => $errMsg);
    }

    protected function prepareView() {}
}