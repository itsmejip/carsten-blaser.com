<?php
namespace Jip\Presenter;

use Jip\Model\HeaderModel;
use Jip\View\DefaultView;
use Jip\Library\FileMerge;
use Jip\Library\FileMergeMinifierModul;


class HeaderPresenter extends Dto {

    const HEADER_INCLUDE_TYPES = array("css", "js");

    private $lang;

    private $csrfToken;
    
    public function __construct($path, $lang, $csrfToken) {
        parent::__construct(new HeaderModel($path), new DefaultView(VIEW_PATH . 'header.inc.php', $lang));

        $this->lang = $lang;

        $this->csrfToken = $csrfToken;
    }

    public function handleRequest() {}

    public function canHandleRequest() { return false; }

    public function prepareView() {
        /**
         * JS
         */
        $jsFiles = array();
        $cssFiles = array();
 
        foreach(self::HEADER_INCLUDE_TYPES as $type) {
            if ($type == "js") {
                $files = $this->model->getJsFiles();
                $htmlPath = HTML_JS_PATH;
            } else if ($type == "css") {
                $files = $this->model->getCssFiles();
                $htmlPath = HTML_CSS_PATH;
            }

            $viewFiles = array();
            $minifierModul = new FileMergeMinifierModul($type);
            $fileMerge = new FileMerge();
            $fileMergeName = $this->model->getFilePrefix() . "_merged.$type";
            $fileMerge->setMergedFile( $htmlPath . $fileMergeName);

            foreach ($files as $file) {
                $modules = array();
                if (!$file["external"] && $file["merge"]) {
                    if ($file["minify"]) {
                        $modules[] = $minifierModul;
                    }
                    $fileMerge->add(substr(VIEW_PATH, 0, strlen(VIEW_PATH) -1) . $file["url"], $modules);
                }
                
                if ($file["external"] || !$file["merge"]) {
                    unset($file["external"]);
                    unset($file["merge"]);
                    unset($file["minify"]);

                    /**
                     * Replace language settings
                     */
                    $file["url"] = str_replace("{{lang}}", $this->lang, $file["url"]);

                    $viewFiles[] = $file;
                }
            }
    
            if ($fileMerge->size() > 0) {
                $fileMerge->merge(DEBUG_MODE);
                $viewFiles[] = array("url" => "/$type/" .  $fileMergeName);
            }

            if ($type == "js") {
                $viewJsFiles = $viewFiles;
            } else if ($type == "css") {
                $viewCssFiles = $viewFiles;
            }
        }

        if ($this->csrfToken) {
            $this->model->addMetaTag('csrf-token', $this->csrfToken);
        }

        $this->view->addVariable("jsFiles", $viewJsFiles);
        $this->view->addVariable("cssFiles",  $viewCssFiles);
        $this->view->addVariable("tags", $this->model->getMetaTags($this->lang));
        $this->view->addVariable("title", $this->model->getTitle($this->lang));
    }
}
