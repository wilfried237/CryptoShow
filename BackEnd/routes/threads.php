<?php
    require("./controllers/thread.controller.php");

    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];

    switch($uri){
        case'/threads/book':
            book_threads();
        break;
        case '/threads/cancel':
            cancel_thread();
        break;
        case '/threads/getParticipants':
            getParticipants();
        break;
        case '/threads/':
            show_all_threads();
        break;
        default:
            echo'Page not found 404';
        break;
    }

?>