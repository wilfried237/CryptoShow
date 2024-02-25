<?php
    require("./functions/function.php");

    $uri = parse_url($_SERVER['REQUEST_URI'])['path']; // seperating the url's query and path
    
    $routes= [
        '/'=> './pages/home/home.php',
        '/about'=> './pages/aboutus/aboutUs.php',
        '/contact'=> './pages/contactus/contact.php',
        '/threads'=>'./pages/threads/threads.php',
        '/login'=>'./pages/login/login.php',
        '/register'=>'./pages/registration/registration.php',
    ];

    routes_to_Controller($uri,$routes);
?>