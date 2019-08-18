<?php
namespace Jip\Model;

use Jip\Library\ITransModule;

class SkillModel implements IModel {

    private $skills;

    public function __construct($jsonFile) {
        $this->loadFile($jsonFile);
    }

    private function loadFile($file) {
        if (!file_exists($file))
            throw new \Exception("File not found '$file'.");

        $this->skills = json_decode(file_get_contents($file), true);
    }

    public function get($section, $key) {
        $skill = null;
        foreach ($this->skills[$section]  as $s) {
            if ($s["key"] == $key) {
                $skill = $s;
                break;
            }
        }
        return $skill;
    }

    public function getAll() {
        return $this->skills;
    }

    public function sortByRowAndSkill() {
        // Already sorted in json
        return;
    }
}

?>