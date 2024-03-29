<?php

session_start();

function authenticate_user() {
    // Check if the user is logged in
    if (!isset($_SESSION['Member_id'])) {
        http_response_code(401);
        echo json_encode(array('error' => 'Unauthorized'));
        exit();
    }
}

?>