<?php

namespace App\Config;

class Router
{
    private $handlers;
    private $notFoundHandler;

    public function get($path, $handler)
    {
        $this->addHandler('GET', $path, $handler);
    }

    public function post($path, $handler)
    {
        $this->addHandler('POST', $path, $handler);
    }

    public function delete($path, $handler)
    {
        $this->addHandler('DELETE', $path, $handler);
    }

    private function addHandler($method, $path, $handler)
    {
        $this->handlers[$method.$path] = [
            'path' => $path,
            'method' => $method,
            'handler' => $handler
        ];
    }

    public function setNotFoundHandler($handler)
    {
        $this->notFoundHandler = $handler;
    }

    public function run()
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $requestPath = $requestUri['path'];
        $method = $_SERVER['REQUEST_METHOD'];
        $callback = null;

        foreach ($this->handlers as $handler) {
            
            if ($handler['path'] === $requestPath &&  $method === $handler['method'] ) {
                $callback = $handler['handler'];
            }
        }
        
        if (!$callback) {
            if (!empty($this->notFoundHandler)) {
                $callback = $this->notFoundHandler;
            }
        }
        call_user_func($callback);

    }
}