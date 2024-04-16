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
        case '/members/update':
            update_user(); 
        break;
        case '/members/get_by_id':
            getUser();
        break;
        case '/members/request_level_up':
            request_level_up();
        break;
        case'/members/updatePassword':
            forget_Password();
        break;
        case '/members/hasRequested':
            hasRequested();
        break;
        default:
            echo'page not found 404';
        break;
    }
?>