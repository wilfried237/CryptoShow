<?php

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
switch ($uri) {
    case '/style/navbar':
        require('./components/Navbar/Navbar.css');
    break;
    case '/style/register':
        require('./pages/registration/registration.css');
    break;
    default:
    break;
}
?>