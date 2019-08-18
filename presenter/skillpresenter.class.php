<?php
namespace Jip\Presenter;

use Jip\Model\SkillModel;
use Jip\Library\FileTransModule;
use Jip\View\DefaultView;



class SkillPresenter extends Dto {

    private $lang;

    private $skillTransModule;

    public function __construct($dataFile, $lang) {
        parent::__construct(new SkillModel($dataFile), new DefaultView(VIEW_SECTIONS_PATH . 'index.skills.inc.php', $lang));

        /**
         * Translation module for skills
         */
        $this->skillTransModule = new FileTransModule(LANG_PATH . $lang . DIRECTORY_SEPARATOR . "index.skills.modul.json");

        /**
         * Set view translation module
         */
        $this->view->setTransModuleFile(LANG_PATH . $lang . DIRECTORY_SEPARATOR . "index.skills.json");
    }

    public function handleRequest() {}

    public function canHandleRequest() { return false; }

    protected function prepareView() {
        $this->model->sortByRowAndSkill();
        $skills = $this->model->getAll();

        /**
         * Translate skills when module exists
         */
        if ($this->skillTransModule) {
            $sectionNames = array_keys($skills);
            for($i = 0; $i< sizeof($skills);$i++) {
                $sectionName =  $sectionNames[$i];
                $skills[$sectionName]["title"] =  $this->skillTransModule->get(strtoupper($sectionName) . "_TITLE");
                for ($j = 0;$j<sizeof($skills[$sectionName]["items"]);$j++) {
                    $skills[$sectionName]["items"][$j]["title"] = $this->skillTransModule->get(strtoupper($sectionName) . "_" . strtoupper($skills[$sectionName]["items"][$j]["key"]) . "_TITLE");
                    $skills[$sectionName]["items"][$j]["text"] = $this->skillTransModule->get(strtoupper($sectionName) . "_" . strtoupper($skills[$sectionName]["items"][$j]["key"]) . "_TEXT");
                }
            }
        }

        $this->view->addVariable("skills", $skills);
    }
}