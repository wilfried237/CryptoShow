<?php
    require("./controllers/admin.controller.php");
    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];

    switch ($uri) {
        case '/admin/delete_user':
            delete_user();
        break;
        case '/admin/delete_organiser':
            delete_organiser();
        break;
        case'/admin/update_organiser':
            update_organiser();
        break;
        case '/admin/upgrade_organiser':
            upgrade_organiser();
        break; 
        case '/admin/downgrade_organiser':
            downgrade_organiser();
        break;
        case '/admin/thread_list':
            thread_list();
        break;
        default:
            echo'Page not found 404';
        break;
    }

?>