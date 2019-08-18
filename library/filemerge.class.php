<?php
    namespace Jip\Library;

    class FileMerge {
        
        private $files;

        private $mergedFile;

        public function __construct() {
            $this->files = array();
        }

        public function size() {
            return sizeof($this->files);
        }

        public function add($file, $modules = array()) {
            if (!file_exists($file))  {
                throw new \Exception("File does not exists '$file'");
            }

            if (!is_array($modules)) {
                throw new \Exception("modules needs to be an array of type IFileMergeModul");
            }

            foreach ($modules as $module) {
                if (!($module instanceof IFileMergeModul)) {
                    throw new \Exception("modules needs to be an array of type IFileMergeModul");
                }
            }

            $this->files[] = array("file" => $file, "modules" => $modules);
        }

        public function isNeeded() {
            $needMerge = !file_exists($this->mergedFile);

            if (!$needMerge) {
                $mfLastModified = filemtime($this->mergedFile);
                if ($this->files) {
                    foreach ($this->files as $file) {
                        if (file_exists($file["file"]) && filemtime($file["file"]) > $mfLastModified) {
                            $needMerge = true;
                            break;
                        }
                    }
                }
            }
            return $needMerge;
        }

        public function merge($force = false) {
            if (!$force && !$this->isNeeded()) {
                return;
            }

            $content = "";

            foreach ($this->files as $file) {
                if (file_exists($file["file"])) {
                    $fileContent = file_get_contents($file["file"]);
                    foreach($file["modules"] as $module) {
                        if (!$module->modify($fileContent)) {
                            throw new \Exception("Error on Module " . get_class($module) . " during content modification.");
                        }
                    }
                    $content .= $fileContent . PHP_EOL;
                } else {
                    throw new \Exception("File does not exists: " . $file["file"]);
                }
            }

            if (!is_null($this->mergedFile)) {
                file_put_contents($this->mergedFile, $content);
            }

            return $content;
        }

        public function setMergedFile($mergedFile) {
            $this->mergedFile = $mergedFile;
            return $this;
        }
    }

?>