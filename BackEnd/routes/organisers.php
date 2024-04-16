<?php
    require_once("./controllers/organiser.controller.php");

    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];

    switch($uri){
        case'/organisers/create':
            create_threads();
        break;
        case'/organisers/update_thread':
            update_thread();
        break;
        case'/organisers/delete_thread':
            delete_thread();
        break;
        case'/organisers/delete_member_thread':
            delete_member_thread();
        break;
        case '/organisers/show_all_organisers':
            show_all_organisers();
        break;
        case '/organisers/Show_thread':
            show_threads_organizer();
        break;
        case'/organisers/get_number_Devices':
            number_devices();
        break;
        case'/organisers/get_member_Devices':
            get_member_device();
        break;
        default:
            echo'Page not found 404';
        break;
    }

?>