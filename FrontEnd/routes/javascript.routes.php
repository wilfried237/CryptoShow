<?php

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
switch ($uri) {
    case '/javascript/registration':
        require('./pages/registration/registration.js');
    break;
    default:
    break;
}
?>