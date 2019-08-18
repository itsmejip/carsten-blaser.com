<?php
namespace Jip\Presenter;

use Jip\Model\PortfolioModel;
use Jip\View\DefaultView;

class PortfolioPresenter extends Dto {

    public function __construct($dataFile, $lang) {
        parent::__construct(new PortfolioModel($dataFile), new DefaultView(VIEW_SECTIONS_PATH . 'index.portfolio.inc.php', $lang));
        
        /**
         * Set view translation module
         */
        $this->view->setTransModuleFile(LANG_PATH . $lang . DIRECTORY_SEPARATOR . "index.portfolio.json");
    }
    
    public function handleRequest() {}

    public function canHandleRequest() { return false; }

    protected function prepareView() {
        $data = $this->model->getAll();
        $this->view->addVariable("portfolio", $data);
    }
}