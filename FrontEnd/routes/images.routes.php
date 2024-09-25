<?php
$uri = $_SERVER['REQUEST_URI'];

switch ($uri) {
    case '/images/logo':
        $imagePath = './images/logo.png';
        break;

    case '/about-us/image1':
        $imagePath = './images/team1.jpg';
        break;

    case '/about-us/image2':
        $imagePath = './images/top-image2.jpeg';
        break;

    default:
        // Handle 404 or default image
        $imagePath = './images/default.jpg';
        break;
}
?>
