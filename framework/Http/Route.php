<?php

namespace MfaFast\Http;

use MfaFast\View\View;

class Route
{
    protected $request;
    protected $response;

    /**
     * @var array to handle all user routes
     */
    protected static $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @param $route string url
     * @param $action array|string to handle controller and controller action of this url
     * @return void to set all get url routes with it`s actions in static variable routes
     */
    public static function get($route, $action)
    {
        self::$routes['get'][$route] = $action;
    }

    /**
     * @param $route string url
     * @param $action array|string to handle controller and controller action of this url
     * @return void to set all post url routes with it`s actions static variable routes
     */
    public static function post($route, $action)
    {
        self::$routes['post'][$route] = $action;
    }

    public function resolve()
    {
        $path = $this->request->path();
        $method = $this->request->method();
        $action = self::$routes[$method][$path] ?? false;

        if (!array_key_exists($path, self::$routes[$method])) {
            $this->response->setStatusCode(404);
            return view("errors.404");
        }

        if(is_array($action)) {
            $controller = new $action[0];
            $method = $action[1];

            //$controller.$method();
            call_user_func_array([$controller, $method], []);
        }elseif(is_callable($action)){
            call_user_func_array($action, []);
        }
    }
}
