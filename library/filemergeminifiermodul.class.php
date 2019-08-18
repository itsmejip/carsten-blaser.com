<?php
    namespace Jip\Library;

    use MatthiasMullie\Minify\JS;
    use MatthiasMullie\Minify\CSS;

    class FileMergeMinifierModul implements IFileMergeModul {
        
        const SUPPORTED_TYPES = array("js", "css");

        const COMMENT_PATTERN = '/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\'|\")\/\/.*))/';
	
        const BLANK_LINES = '/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/';

        private $type = "js";

        private $minifier = null;


        public function __construct($type) {
            if (!in_array($type, self::SUPPORTED_TYPES, true)) {
                throw new Exception("Not supported type '$type'");
            }

            $this->type = $type;

            if ($type == "js") {
                $this->minifier = new JS();
            } else if ($type == "css") {
                $this->minifier = new CSS();
            } else {
                throw new Exception("No minifier initialized");
            }
        }

        public function modify(&$data) {
            // Remove commands and blank lines beforehand (only js)
            if ($this->type == "js") {
                $data = preg_replace(self::COMMENT_PATTERN, '', $data);
                $data = preg_replace(self::BLANK_LINES, "\n", $data);
            }

            $this->minifier->clear();
			$this->minifier->add($data);
            $data = $this->minifier->minify();
            
            if ($this->type == "js") {  
                $data .= ";";
            }

            return true;
        }
    }