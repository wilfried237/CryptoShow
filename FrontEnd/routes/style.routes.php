<?php

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
switch ($uri) {
    case '/style/navbar':
        require('./components/Navbar/Navbar.css');
    break;
    case '/style/register':
        require('./pages/registration/registration.css');
    break;
    case '/style/login':
        require('./pages/login/login.css');
    break;
    case '/style/personal':
        require('./pages/personalAccount/personal.css');
    break;
    case '/style/threads':
        require('./pages/threads/threads.css');
    break;
    case '/style/threadInfo':
        require('./pages/threadInfo/threadInfo.css');
    break;
    default:
    break;
}
?>