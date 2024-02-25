<?php
require("./functions/function.php");
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$routes= [
    '/images/logo'=> './images/logo.png',
];

routes_to_Controller($uri,$routes);
?>