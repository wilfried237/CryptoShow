<?php
    require("./controllers/members.controller.php");

    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];

    switch ($uri) {
        case '/members/login':
            register_member();
        break;
        case '/members/register':
            login_member();
        break;
        case '/members':
            show_all_member();
        break;
    }
?>