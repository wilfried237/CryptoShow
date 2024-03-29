<?php 
require("./function/function.php");
require_once("./function/authentication.php");
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$routes = [
    '/admin'=> './routes/admin.php',
    '/members'=> './routes/members.php',
    '/organisers'=> './routes/organisers.php',
    '/threads'=> './routes/threads.php',
    '/user'=> './routes/user.php',
    '/device'=>'./routes/device.php',
];

if (in_array($uri, ['/admin', '/members', '/organisers', '/threads', '/user', '/device'])) {
    authenticate_user();
}

routes_to_Controller($uri, $routes);
?>
