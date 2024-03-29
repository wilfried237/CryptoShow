<?php
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

switch ($uri) {
    case '/images/logo':
     require('./images/logo.png');
    break;

    case '/images/background01':
        require('');
    break;

    case '/images/background02':
        require('');
    break;

    case '/images/background03':
        require('');
    break;

    case '/images/background04':
        require('');
    break;

    case '/images/background05':
        require('');
    break;

    case '/images/background06':
        require('');
    break;

    case '/images/background07':
        require('');
    break;

    case '/images/background08':
        require('');
    break;

    case 'images/background09':
        require('');
    break;

    case 'images/background10':
        require('');
    break;

    case '/about-us/image1':
        require('./images/top-image.jpeg');
    break;
    case '/about-us/image2':
        require('./images/top-image2.jpeg');
    break;
}


?>