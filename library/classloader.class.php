<?php
	class ClassLoader {
		
		private $basePath = "/";

		const ALIASES = array(
			"Jip\Library" =>  "library/",	
			"Jip\Library\Ajax" =>  "library/ajax/",	
			"Jip\Presenter" =>  "presenter/",	
			"Jip\View" =>  "view/",	
			"Jip\Model" =>  "model/",
			"MatthiasMullie\Minify" => "library/external/minify-master/src/",
			"MatthiasMullie\Minify\Exceptions" => "library/external/minify-master/src/Exceptions",	
			"PHPMailer" => "library/external/phpmailer/"
		);
		
		public function __construct($basePath) {
			$this->basePath = $basePath; 
		}
		
		protected function findClassFile($class) {		
			$pos = strrpos($class,'\\');
			$namespace = substr($class,0, $pos);
			$className = strtolower(substr($class,$pos +1));
			$folder = self::ALIASES[$namespace];
			
			if (!$folder)
				$folder = "/";
			$file = $this->basePath . $folder . "$className.class.php";
			if (file_exists($file)) {
				include $file;		
			}		
		}
		
		public function register() {
			spl_autoload_register(array($this, 'findClassFile'));
		}
		
		public function unregister() {
			spl_autoload_unregister(array($this, 'findClassFile'));
		}

		public function getBasePath() {
			return $this->basePath;
		}
	}
?>