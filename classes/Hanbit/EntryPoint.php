<?php
    namespace Hanbit;

    use \Hanbit\Routes;

    class EntryPoint {

        private $route;
        private $method;
        private $routes;

        public function __construct(string $route, string $method, Routes $routes) {
            $this -> route = $route;
            $this -> method = $method;
            $this -> routes = $routes;
            $this -> checkUrl();
        }

        private function checkUrl() {
            if ($this -> route !== strtolower($this -> route)) {
                http_response_code(301);
                header('location: ' . strtolower($this -> route));
            }
        }

        private function loadTemplate($templateFileName, $variables = []) {
            extract($variables);
    
            ob_start();
    
            include __DIR__ . '/../../templates/' . $templateFileName;
    
            return ob_get_clean();
        }

        public function run() {
            $routes = $this -> routes -> getRoutes();

            $controller = $this -> routes[$routes][$this -> method]['controller'];
            $action = $this -> routes[$routes][$this -> method]['action'];

            $page = $controller -> $action();

            $title = $page['title'];

            if (isset($page['variables'])) {
                $output = $this -> loadTemplate($page['template'], $page['variables']);
            } else {
                $output = $this -> loadTemplate($page['template']);
            }

            include __DIR__ . '/../../templates/layout.html.php';
        }
    }