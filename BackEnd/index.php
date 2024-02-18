<?php 
require("./function/function.php");

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$routes = [
    '/admin'=> './routes/admin.php',
    '/members'=> './routes/members.php',
    '/organisers'=> './routes/organisers.php',
    '/threads'=> './routes/threads.php',
    '/user'=> './routes/user.php',
];

routes_to_Controller($uri,$routes);

?>