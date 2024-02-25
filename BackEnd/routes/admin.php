<?php
    require("./controllers/admin.controller.php");
    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];

    switch ($uri) {
        case '/admin/delete_user':
            delete_user();
        break;
        case '/admin/update_user':
            update_user();
        break;
        case '/admin/delete_organisers':
        break;
        case'/admin/update_organiser':
        break;
        case '/admin/level_up_user':
        break;  
        default:
            echo'Page not found 404';
        break;
    }

?>