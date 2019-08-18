<?php

namespace Jip\Presenter;

    use Jip\Library\FileTransModule;
    use Jip\View\DefaultView;

    class IndexPresenter extends Dto {

        const PATH = "/";
        const PATH_INDEX = "/index.php";

        public function __construct($lang) {
            parent::__construct(null, new DefaultView(VIEW_PATH . 'index.inc.php', $lang));
        }

        public function handleRequest() {}

        public function canHandleRequest() { return false; }

        protected function prepareView() {
            $this->view->addVariable("path", self::PATH);
            $this->view->addVariable("lang", $this->view->getLang());
        }
    }
?>