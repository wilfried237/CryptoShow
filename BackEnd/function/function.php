<?php
function abort($code = 404){
    $list_of_responses = [
        404=>'pages/aborts/404.php',
    ];
    echo "<h1>404 Page Not found</h1>";

}

function routes_to_Controller($uri,$routes){
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
?>