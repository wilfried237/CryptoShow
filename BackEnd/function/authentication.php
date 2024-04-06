<?php


function authenticate_user() {
    // Check if the user is logged in
    if (!isset($_SESSION['auth'])) {
        http_response_code(401);
        echo json_encode(array('error' => 'Unauthorized'));
        exit();
    }
}

function is_authenticated() {
    return isset($_SESSION['Member_id']); 
}


function is_admin() {
    if (authenticate_user()) {

        $conn = connection_to_Maria_DB();
        $Member_id = $_SESSION['Member_id'];
        $sql = 'SELECT Surface FROM Member WHERE Member_id = :Member_id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':Member_id', $Member_id);
        $stmt->execute();
        $Surface = $stmt->fetchColumn();
        if($Surface == 1){
            return true;
        }
        return false;
        
    }
    return false; 
}

?>