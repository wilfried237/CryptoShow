<?php
    require("./controllers/device.controller.php");
    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];

    switch ($uri) {
        case '/device/register_device':
           register_device();
        break;
        case '/device/delete_device':
            delete_device();
        break;
        case'/device/edit_device':
            edit_device();
        break;
        default:
            echo'Page not found 404';
        break;
    }

?>