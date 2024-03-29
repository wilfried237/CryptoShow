<?php

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
switch ($uri) {
    case '/style/navbar':
        require('./components/Navbar/Navbar.css');
    break;

    case '/style/footer':
        require('./components/Footer/Footer.css');
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

    case '/style/aboutUs':
        require('./pages/aboutUs/aboutUs.css');
    break;

    case '/style/contactUs':
        require('./pages/contactus/contact.css');
    break;

    case '/style/home':
        require('./pages/home/home.css');
    break;
    
    case '/style/event':
        require('./pages/threads/threads.css');
    break;

    case '/style/admin':
        require('./pages/admin/admin.css');
    break;

    case '/style/admin_member':
        require('./pages/admin_member/member.css');
        break;

    case '/style/admin_event':
        require('./pages/admin_event/event.css');
        break;

    case '/style/admin_devices':
        require('./pages/admin_devices/devices.css');
        break;

    default:
    break;
}
?>