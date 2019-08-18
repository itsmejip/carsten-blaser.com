<?php
    namespace Jip\Model;

    use Jip\Library\ITransModule;

    class StatusCodeMessages implements IModel {

        const STATUS_CODE_DATA = array(
            "en" => array(
                "404" => array(
                    "title" => "Whoops, this is a dead end",
                    "text" => "Sorry the page you are looking for does not exist anymore",
                    "link" => array(
                        "url" => "https://www.carsten-blaser.com",
                        "text" => "Back to website"
                    )
                ),
                "405" => array(
                    "title" => "Think about it twice",
                    "text" => "The chosen method to communicate with me is not supported.",
                    "link" => array(
                        "url" => "https://www.carsten-blaser.com",
                        "text" => "Back to website"
                    )
                )
            ),
            "de" => array(
                "404" => array(
                    "title" => "Whoops, das ist eine Sackgasse",
                    "text" => "Die Seite, die Du suchst, existiert nicht mehr.",
                    "link" => array(
                        "url" => "https://www.carsten-blaser.com",
                        "text" => "Zurück zur Hauptseite"
                    )
                ),
                "405" => array(
                    "title" => "Denk drüber nach",
                    "text" => "Deine gewählte Methode wird nicht unterstützt.",
                    "link" => array(
                        "url" => "https://www.carsten-blaser.com",
                        "text" => "Back to website"
                    )
                )
            )
        );

        public function getValues($lang = 'en') {
            return self::STATUS_CODE_DATA[$lang];
        }
    
        public function setValue($key, $value) {}

        public function setArray($array) {}

        public function save() {}

        public function load() {}

        public function setTranslationModule(ITransModule $module) {}

        public function getTranslationModule() { return null; }

    }

?>
