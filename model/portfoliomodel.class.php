<?php
namespace Jip\Model;

class PortfolioModel implements IModel {

    private $portfolio;

    public function __construct($jsonFile) {
        $this->loadFile($jsonFile);
    }

    private function loadFile($file) {
        if (!file_exists($file))
            throw new \Exception("File not found '$file'.");

        $this->portfolio = json_decode(file_get_contents($file), true);
    }

    public function getAll() {
        return $this->portfolio;
    }
}

?>