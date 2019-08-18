<?php
namespace Jip\Presenter;

use Jip\View\DefaultView;

class SideMenuPresenter extends Dto {

    private $path;

    public function __construct($lang, $path) {
        parent::__construct(null, new DefaultView(VIEW_PATH . 'sidemenu.inc.php', $lang));

        $this->path = $path;

        /**
         * Set view translation module
         */
        $this->view->setTransModuleFile(LANG_PATH . $lang . DIRECTORY_SEPARATOR . "sidemenu.json");


    }

    public function handleRequest() {}

    public function canHandleRequest() { return false; }

    protected function prepareView() {
        $this->view->addVariable("lang", $this->view->getLang());
        $this->view->addVariable("path", $this->path);
    }
}