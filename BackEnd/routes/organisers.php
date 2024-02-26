<?php
    require("./controllers/organiser.controller.php");

    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];

    switch($uri){
        case'/organisers/create':
            create_threads();
        break;
        case '/organisers/show_all_organisers':
            show_all_organisers();
        break;
        default:
            echo'Page not found 404';
        break;
    }

?>