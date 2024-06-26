<?php

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
switch ($uri) {
    case '/javascript/registration':
        require('./pages/registration/registration.js');
    break;
    case '/javascript/forgetPassword':
        require('./pages/forgetPassword/forgetPassword.js');
    break;
    case '/javascript/login':
        require('./pages/login/login.js');
    break;
    case '/javascript/navbar':
        require('./components/Navbar/Navbar.js');
    break;
    case '/javascript/personal':
        require('./pages/personalAccount/personal.js');
    break;
    case '/javascript/threads':
        require('./pages/threads/threads.js');
    break;
    case '/javascript/threadInfo':
        require('./pages/threadInfo/threadInfo.js');
    break;
    case '/javascript/CreateEvent':
        require('./pages/OrganiserThread/createEvent.js');
    break;
    case '/javascript/allMembers':
        require('./pages/OrganiserThread/allMembers.js');
    break;
    case '/javascript/allDevice':
        require('./pages/OrganiserThread/allDevices.js');
    break;
    default:
    break;
}
?>