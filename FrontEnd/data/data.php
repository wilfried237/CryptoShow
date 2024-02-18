<?php 

    #Associative Arrays
    return [
        "threads"=> require("./fetchFunctions/threads.fetch.php"),
        "member"=> require("./fetchFunctions/member.fetch.php"),
        "devices"=> require("./fetchFunctions/device.fetch.php"),
    ];
?>