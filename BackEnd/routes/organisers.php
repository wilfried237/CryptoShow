<?php
    require_once("./controllers/organiser.controller.php");

    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];

    switch($uri){
        case'/organisers/create':
            create_threads();
        break;
        case '/organisers/show_all_organisers':
            show_all_organisers();
        break;
        case '/organisers/request_level_up':
            request_level_up();
        break;
        case '/organisers/Show_thread':
            show_threads_organizer();
        break;
        default:
            echo'Page not found 404';
        break;
    }

?>