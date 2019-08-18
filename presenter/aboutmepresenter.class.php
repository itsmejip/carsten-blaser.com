<?php 
    namespace Jip\Presenter;

    use Jip\Library\FileTransModule;
    use Jip\View\DefaultView;

    class AboutMePresenter extends Dto {

        public function __construct($lang) {
            parent::__construct(null, new DefaultView(VIEW_SECTIONS_PATH . 'index.aboutme.inc.php', $lang));

            /**
             * Set view translation module file
             */
            $this->view->setTransModuleFile(LANG_PATH . $lang . DIRECTORY_SEPARATOR . "index.aboutme.json");
        }

        public function handleRequest() {}
        
        public function canHandleRequest() { return false; }

        protected function prepareView() {}
    }
?>