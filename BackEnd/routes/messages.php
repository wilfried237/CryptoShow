<?php

    require("./controllers/messages.controller.php");
    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];

    switch ($uri) {
        case '/messages/send_messages':
            send_messages();
        break;
        case '/messages/sent_messages':
            sent_messages();
        break;
        case '/messages/received_messages':
            received_messages();
        break;
        default:
            echo'Page not found 404';
        break;
    }

?>