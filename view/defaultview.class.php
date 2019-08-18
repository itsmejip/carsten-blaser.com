<?php
namespace Jip\View;

use Jip\Library\FileTransModule;

class DefaultView implements IView {

    protected $viewData;

    protected $templateFile;

    protected $lang;

    protected $transModuleFile;

    public function getTemplateFile() {
        return $this->templateFile;
    }

    public function __construct($templateFile, $lang) {
        if (!file_exists($templateFile)) {
            throw new \Exception("Template does not exist: $templateFile");
        }

        $this->templateFile = $templateFile;
        $this->lang = $lang;

        $this->viewData = array();
    }

    public function addVariable($variableName, $data) {
        $this->viewData[$variableName] = $data;
    }

    public function removeVariable($variableName) {
        unset($this->viewData[$variableName]);
    }

    public function show($forceCreation = false) {
        // Prepare variables
        if (sizeof($this->viewData) > 0) {
            foreach ($this->viewData as $name => $value) {
                global $$name;
                $$name = $value;
            }
        }
        // Include translated version
        INCLUDE $this->createTranslatedView($forceCreation);
    }

    private function createTranslatedView($forceCreation = false) {
        if (is_null($this->transModuleFile) || !file_exists($this->transModuleFile)) {
           return $this->templateFile;
        }

        $translatedFile = substr($this->templateFile, 0, -3) . $this->lang . ".php";
        $modifiedTime = (file_exists($translatedFile) && !$forceCreation ? filemtime($translatedFile) : 0);

        /**
         * Create translation file if changes occured
         */
        if ($modifiedTime < filemtime($this->transModuleFile) || $modifiedTime < filemtime($this->templateFile)) {
            
            $transModule = new FileTransModule($this->transModuleFile);
            $originalContent = file_get_contents($this->templateFile);
            $translatedContent = $transModule->replace($originalContent);
            file_put_contents($translatedFile, $translatedContent);
        }

        return $translatedFile;
    }

    public function setTransModuleFile($file) {
        $this->transModuleFile = $file;
    }

	public function getLang() {
		return $this->lang;
	}
}