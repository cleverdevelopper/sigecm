<?php
    #====================================================
    # Router
    #====================================================
    namespace App\Http;
    use \Closure;
    use \Exception;
    use \ReflectionFunction;
    use App\Http\Middleware\Queue as MiddlewareQueue;

    class Router{
        private $url = ''; 
        private $prefixo = '';
        private $routes = []; 
        private $request; 
        private $contentType = 'text/html';

        public function __construct($url){
            $this->request       = new Request($this);
            $this->url           = $url;
            $this->setPrefix();
        }

        public function setContentType($contentType){
            $this->contentType = $contentType;
        }

        private function setPrefix(){
            $parseUrl = parse_url($this->url);
            $this->prefixo = $parseUrl['path'] ?? '';
        }

        private function addRoute($method, $route, $params = []){
            foreach($params as $key=>$value){
                if($value instanceof Closure){
                    $params['controller'] = $value;
                    unset($params[$key]);
                    continue;
                }
            }
            $params['middlewares'] = $params['middlewares'] ?? [];

            $params['variables'] = [];

            $pattenVariables = '/{(.*?)}/';
            if(preg_match_all($pattenVariables, $route, $matches)){
                $route = preg_replace($pattenVariables, '(.*?)', $route);
                $params['variables'] = $matches[1];
            }

            $paternRoute = '/^'.str_replace('/', '\/', $route).'$/';
            $this->routes[$paternRoute][$method] = $params;
        }
        
        public function get($route, $params = []){
            return $this->addRoute('GET', $route, $params); 
        }

       
        public function post($route, $params = []){
            return $this->addRoute('POST', $route, $params); 
        }
        
        public function put($route, $params = []){
            return $this->addRoute('PUT', $route, $params);
        }

        public function delete($route, $params = []){
            return $this->addRoute('DELETE', $route, $params);
        }

        private function getUri(){
            $uri = $this->request->getUri();
            $xUri = strlen($this->prefixo) ? explode($this->prefixo, $uri) : [$uri];
            return end($xUri);
        }

        private function getRoute(){
            $uri = $this->getUri();

            $httpMethod = $this->request->getHttpMethod();

            foreach($this->routes  as $paternRoute=>$methods){
                if(preg_match($paternRoute, $uri, $matches)){
                    if(isset($methods[$httpMethod])){
                        unset($matches[0]);
                        $keys = $methods[$httpMethod]['variables'];
                        $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
                        $methods[$httpMethod]['variables']['request'] = $this->request;

                        return $methods[$httpMethod];
                    }
                    throw new Exception ("Metodo não permitido", 405);
                }
            }
            throw new Exception ("URL não encontrada", 404);
        }

        public function run(){
            try{
                $route = $this->getRoute();

                if(!isset($route['controller'])){
                    throw new Exception ("A URL não pode ser processada", 500);
                }
                $args = [];
              
                $reflection = new ReflectionFunction($route['controller']);
                foreach($reflection->getParameters() as $parameter){
                    $name = $parameter->getName();
                    $args[$name] = $route['variables'][$name] ?? '';
                }

                return (new MiddlewareQueue($route['middlewares'], $route['controller'], $args))->next($this->request);

            }catch (Exception $e) {
                return new Response($e->getCode(), $this->getErrorMessage($e->getMessage()), $this->contentType);
               }
        }

        private function getErrorMessage($message){
            switch($this->contentType){
                case 'application/json':
                    return [
                        'error' => $message
                    ];
                    break;
                default:
                    return $message;
                    break;
            }
        }

        public function redirect($route){
            $url = $this->url.$route;
            header('location: '.$url);
            exit;
        }

        public function getCurrentUrl(){
            return $this->url.$this->getUri();
        }
    }
?> 


