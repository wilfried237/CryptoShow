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
  case '/style/aboutus':
      require('./pages/aboutus/about.css');
  break;
  case '/style/contact':
      require('./pages/contactus/contact.css');
  break;
    default:
    break;
}
?>