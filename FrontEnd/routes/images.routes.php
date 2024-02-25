<?php
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

switch ($uri) {
    case '/images/logo':
    require('./images/logo.png');
    break;
    default:
    break;
}


?>