<?php
    require("./functions/function.php");

    $uri = parse_url($_SERVER['REQUEST_URI'])['path']; // seperating the url's query and path
    
    $routes= [
        '/'=> './pages/home/home.php',
        '/about'=> './pages/aboutus/aboutUs.php',
        '/contact'=> './pages/contactus/contact.php',
        '/threads'=>'./pages/threads/threads.php',
        '/login'=>'./pages/login/login.php',
        '/register'=> './pages/registration/registration.php',
        '/personalAccount'=> './pages/personalAccount/personal.php',
        '/style'=>'./routes/style.routes.php',
        '/images'=> './routes/images.routes.php',
        '/javascript'=> './routes/javascript.routes.php',
    ];

    routes_to_Controller_front($uri,$routes);
?>