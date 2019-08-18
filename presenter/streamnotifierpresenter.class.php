<?php 
    namespace Jip\Presenter;

    use Jip\View\DefaultView;

    class StreamNotifierPresenter extends Dto {

        public function __construct($lang) {
            parent::__construct(null, new DefaultView(VIEW_PATH . 'streamnotifier.inc.php', $lang));

            /**
             * Set view translation module
             */
            $this->view->setTransModuleFile(LANG_PATH . $lang . DIRECTORY_SEPARATOR . "streamnotifier.json");
        }

        public function handleRequest() {}

        public function canHandleRequest() { return false; }

        protected function prepareView() {}
    }
?>