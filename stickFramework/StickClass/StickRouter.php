<?php
namespace StickFramework\StickClass;
use StickFramework\StickFramework as StickFramework;

/**
 * [final description]
 * @var [type]
 */
final class StickRouter
{
    /**
     * [$routes description]
     * @var [type]
     */
    private $routes;

    /**
     * [__construct description]
     */
    public function __construct(){
        $this->routes = require(ROOT.'/app/routes.php');
    }

    /**
     * [redirect description]
     * @param  [type] $r [description]
     * @return [type]    [description]
     */
    public function redirect($r){
        if (!array_key_exists($r,$this->routes)) {
            header('HTTP/1.0 404 Not Found');
            StickFramework::notFound();
        } else {
            $endPoint = explode('.', $this->routes[$r]);
            $controllerName = $endPoint[0];
            $action = $endPoint[1];

            is_dir(ROOT.'/app/Controllers/'.$controllerName)
            ? $controller = 'App\Controllers\\' .$controllerName."\\".ucfirst($controllerName)
            : $controller = 'App\Controllers\\'.ucfirst($controllerName);

            $controller = new $controller;
            $controller->$action();

        }
    }

}

 ?>
