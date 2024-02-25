<?php
require("./functions/function.php");
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$routes= [
    '/style/navbar'=> './components/Navbar/Navbar.css',
];

routes_to_Controller($uri,$routes);
?>