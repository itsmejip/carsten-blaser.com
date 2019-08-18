<?php
namespace Jip\Library;

class Router {

    private  $routes;

    private $statusCodeDelegates;

    public function __construct() {
        $this->routes = array();
        $this->statusCodeDelegates = array();
    }

    public function add($expression, $delegate, $method = 'get') {
        array_push(
            $this->routes, 
            array(
                'expression' => $expression,
                'delegate' => $delegate,
                'method' => strtolower($method)
            )
        );
    }

    public function addStatusCodeDelegate($statusCode, $delegate) {
        if ($statusCode != 200) {
            $this->statusCodeDelegates[strval($statusCode)] = $delegate;
        }
    }


    private function routeStatusCodeDelegate($statusCode, $parameter = array()) {
        if (http_response_code($statusCode)) {
            $delegate =  $this->statusCodeDelegates[strval($statusCode)];
            if (!is_null($delegate)) {
                call_user_func_array($delegate, $parameter);
            }
        }
    }

    public function route($basePath = '/'){
        $urlArray = parse_url($_SERVER['REQUEST_URI']);
        if(isset($urlArray['path'])) {
            $path = $urlArray['path'];
        }else{
            $path = '/';
        }

        $method = strtolower($_SERVER['REQUEST_METHOD']);

        foreach($this->routes as $route) {
            if(!empty($basePath) && $basePath != '/' ) {
                $expression = '(' . $basePath . ')' . $route['expression'];
            } else {
                $expression = $route['expression'];
            }
    
            $pageExists = (preg_match('#^' . $expression . '$#', $path, $matches));
            $methodAllowed = $pageExists && ($method == $route['method']);

            if ($methodAllowed) {
                
                array_shift($matches);
                
                if (!empty($basePath) && $basePath != '/' ) {
                    array_shift($matches); 
                }
                
                call_user_func_array($route['delegate'], $matches);

                break;
            }
            
        }

        if (!$methodAllowed) {
            if ($pageExists) {
                $this->routeStatusCodeDelegate(405, array($path, $method));
            } else {
                $this->routeStatusCodeDelegate(404, array($path));
            }
        }
    }

}