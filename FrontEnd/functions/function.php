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

function routes_to_Controller($uri,$routes){
    if(array_key_exists($uri, $routes)) {
        require($routes[$uri]);
    } else {
        abort();
    }
}