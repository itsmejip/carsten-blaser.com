<?php 
    namespace Jip\Presenter;

    use Jip\View\DefaultView;

    class FooterPresenter extends Dto {

        public function __construct($lang) {
            parent::__construct(null, new DefaultView(VIEW_PATH . 'footer.inc.php', $lang));

            /**
             * Set view translation module
             */
            $this->view->setTransModuleFile(LANG_PATH . $lang . DIRECTORY_SEPARATOR . "footer.json");
        }

        public function handleRequest() {}

        public function canHandleRequest() { return false; }

        protected function prepareView() {}
    }
?>