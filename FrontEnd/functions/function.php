<?php

function dd( $value ) {
    echo"<pre>";
    var_dump( $value );
    echo "</pre>";
    die();
}

function Urls($url){
    return $_SERVER['REQUEST_URI'] === $url;
}

function abort($code = 404){
    $list_of_responses = [
        404=>'pages/aborts/404.php',
    ];
    http_response_code($code);
    require($list_of_responses[$code]);

}

function routes_to_Controller_front($uri,$routes){
    if (array_key_exists($uri, $routes)) {
        $controllerPath = $routes[$uri];
        require($controllerPath);
    } else {
        $arrayPath = explode("/", $uri);
        $arrayPath = array_filter($arrayPath);
        $basePath = "/" . reset($arrayPath);
        if (array_key_exists($basePath, $routes)) {
            $controllerPath = $routes[$basePath];
            require($controllerPath);
        } else {
            abort(); // Handle case where the route is not found
        }
    }
}