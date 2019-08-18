<?php
namespace Jip\Model;

class WorkModel implements IModel {

    private $works;

    public function __construct($jsonFile) {
        $this->loadFile($jsonFile);
    }

    private function loadFile($file) {
        if (!file_exists($file))
            throw new \Exception("File not found '$file'.");

        $this->works = json_decode(file_get_contents($file), true);
    }

    public function getAll() {
        return $this->works;
    }

    public function sortByTimeAsc() {
        // Already sorted in json
        return;
    }
}

?>