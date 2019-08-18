<?php 
    namespace Jip\Presenter;

    use Jip\View\DefaultView;

    class StartPresenter extends Dto {

        public function __construct($lang) {
            parent::__construct(null, new DefaultView(VIEW_SECTIONS_PATH . 'index.start.inc.php', $lang));

            /**
             * Set view translation module
             */
            $this->view->setTransModuleFile(LANG_PATH . $lang . DIRECTORY_SEPARATOR . "index.start.json");
        }

        public function handleRequest() {}

        public function canHandleRequest() { return false; }

        protected function prepareView() {}
    }
?>