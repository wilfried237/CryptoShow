<?php

    require("./controllers/search.controller.php");
    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];

    switch ($uri) {
        case '/search/get_thread_names':
            get_thread_names();
        break;
        default:
            echo'Page not found 404';
        break;
    }

?>