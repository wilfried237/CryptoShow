<?php
    require("./controllers/admin.controller.php");
    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];

    switch ($uri) {
        case '/admin/delete_user':
            delete_user();
        break;
        case '/admin/delete_organizer':
        break;
        case'/admin/update_organizer':
        break;
        case '/admin/level_up_organizer':
        break;  
        default:
            echo'Page not found 404';
        break;
    }

?>