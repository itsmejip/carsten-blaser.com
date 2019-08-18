<?php
namespace Jip\Presenter;

use Jip\Model\WorkModel;
use Jip\View\DefaultView;

class WorkPresenter extends Dto {

    public function __construct($dataFile, $lang) {
        parent::__construct(new WorkModel($dataFile), new DefaultView(VIEW_SECTIONS_PATH . 'index.work.inc.php', $lang));
        
        /**
         * Set view translation module
         */
        $this->view->setTransModuleFile(LANG_PATH . $lang . DIRECTORY_SEPARATOR . "index.work.json");
    }

    public function handleRequest() {}

    public function canHandleRequest() { return false; }

    protected function prepareView() {
        $this->model->sortByTimeAsc();
        $work = $this->model->getAll();
        $this->view->addVariable("work", $work);
    }
}