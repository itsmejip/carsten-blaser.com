<?php
namespace Jip\Library;

class FileTransModule implements ITransModule {

    private $translations;

    private $lastModified;

    private $regex = '/\<\@trans.(.+?)\@\>/';

    public function getRegex() {
		return $this->regex;
	}

	public function setRegex($regex) {
		$this->regex = $regex;
		return $this;
    }
    
    public function getLastModified() {
		return $this->lastModified;
    }

    public function __construct($file) {
        $this->loadFile($file);
    }

    private function loadFile($file) {
        if (!file_exists($file))
        throw new \Exception("File not found '$file'.");

        $this->translations = json_decode(file_get_contents($file), true);
        $this->lastModified = filemtime($file);
    }

    public function get($key) {
        $trans = $this->translations[$key];
        if (!is_null($trans)) {
            return $trans;
        }
        return "[-- $key --]";
    }

    public function getAll() {
        return $this->translations;
    }
    
    public function replace($content) {
        $replacements = $this->translations;
        $regex = $this->regex;
		return preg_replace_callback($regex, function($matches) use ($replacements) {
			return $replacements[$matches[1]];
		}, $content);
	}
}

?>