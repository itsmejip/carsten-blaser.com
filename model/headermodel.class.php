<?php
    namespace Jip\Model;

    use Jip\Library\ITransModule;

    class HeaderModel implements IModel {

        const ALL_PAGE_JSCSS = RESOURCES_PAGE_PATH . "__all__.json";

        private $jsFiles;

        private $cssFiles;

        private $metaTags;

        private $title;

        private $filePrefix;

        public function __construct($path) {
            $this->jsFiles = array();
            $this->cssFiles = array();
            $this->metaTags = array();
            $this->title = array();

            $this->addFile(self::ALL_PAGE_JSCSS);

            $path = \substr(\str_replace("/", ".", $path),1);
            if (\substr($path, -3) === "php") {
                $path = \substr($path, 0, strlen($path) - 4);
            } else {
                $path .= "index";
            }

            $this->filePrefix = $path;

            $this->addFile(RESOURCES_PAGE_PATH .  $this->filePrefix . ".json");
        }

        public function getTitle($lang) {
            return $this->title[$lang];
        }
       
        public function getFilePrefix() {
            return $this->filePrefix;
        }

        public function getMetaTags($lang) {
            $foundTags = array();
            foreach ($this->metaTags as $metaTag) {
                if (!isset($metaTag["lang"]) || is_null($metaTag["lang"]) || ($metaTag["lang"] == $lang)) {
                    $foundTags[] = $metaTag;
                }
            }
            return $foundTags;
        }

        public function addMetaTag($name, $content, $lang = null, $attributeName = 'name') {
            $this->metaTags[] = array(
                "attr" => $attributeName,
                "lang" => $lang,
                "name" => $name,
                "content" => $content
            );
        }

        public function getJsFiles() {
            return $this->jsFiles;
        }

        public function getCssFiles() {
            return $this->cssFiles;
        }

        private function addFile($file) {
            if (!file_exists($file)) {
                throw new \Exception("File '$file' does not exist.");
            }

            $data = json_decode(file_get_contents($file), true);

            $this->jsFiles = array_merge($this->jsFiles, $data["js"]);
            $this->cssFiles = array_merge($this->cssFiles, $data["css"]);

            if (is_array( $data["tags"])) {
                $this->metaTags = array_merge($this->metaTags, $data["tags"]);
            }

            if (is_array( $data["title"])) {
                $this->title = array_merge($this->title, $data["title"]);
            }
        }
    }