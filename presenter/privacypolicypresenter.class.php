<?php 
    namespace Jip\Presenter;

    use Jip\Library\FileTransModule;
    use Jip\View\DefaultView;

    class PrivacyPolicyPresenter extends Dto {

        const PATH = "/privacypolicy.php";

        public function __construct($lang) {
            parent::__construct(null, new DefaultView(VIEW_PATH . 'privacypolicy.inc.php', $lang));

            /**
             * Set view translation module file
             */
            $this->view->setTransModuleFile(LANG_PATH . $lang . DIRECTORY_SEPARATOR . "privacypolicy.json");
        }

        public function handleRequest() {}
        
        public function canHandleRequest() { return false; }

        protected function prepareView() {
            $this->view->addVariable("path", self::PATH);
            $this->view->addVariable("lang", $this->view->getLang());
        }
    }
?>