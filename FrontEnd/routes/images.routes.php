<?php
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

switch ($uri) {
    case '/images/logo':
        require('./images/logo.png');
        break;

    case '/about-us/image1':
        require './images/team1.jpg';
        break;

    case '/about-us/image2':
        require './images/top-image2.jpeg';
        break;
}
?>
