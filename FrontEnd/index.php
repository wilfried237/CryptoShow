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
        '/admin' => './pages/admin/admin.php',
        '/personalAccount'=> './pages/personalAccount/personal.php',
        '/threadInfo'=> './pages/threadInfo/threadInfo.php',
        '/CreateEvent'=> './pages/OrganiserThread/createEvent.php',
        '/allMembers' => './pages/OrganiserThread/allMembers.php',
        '/style'=>'./routes/style.routes.php',
        '/images'=> './routes/images.routes.php',
        '/javascript'=> './routes/javascript.routes.php',
    ];

    routes_to_Controller_front($uri,$routes);