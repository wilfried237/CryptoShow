<?php
    require("./controllers/members.controller.php");

    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
    switch ($uri) {
        case '/members/register':
            register_member();
        break;
        case '/members/login':
            login_member();
        break;
        case '/members/':
            show_all_member();
        break;
        default:
            echo'page not found 404';
        break;
    }
?>