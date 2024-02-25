<?php
    require("./function/DBConnection.php");

    function create_threads(){
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['name']) && isset($_POST['location']) && isset($_POST['Member_id'])){
                
                $name = $_POST['name'];
                $location = $_POST['location'];
                $Member_id = $_POST['Member_id'];
                $date =  date("h:i:sa");
                $limit = isset($_POST['limit']) ? $_POST['limit'] :  15;
                
                $conn = connection_to_Sqlite_DB();
                
                $sql_member = "SELECT Surface FROM Member WHERE Member_id = :Member_id;";
                
                $stmt_member = $conn->prepare($sql_member);
                
                $stmt_member->bindParam(':Member_id',$Member_id);
                
                $member_result = $stmt_member->execute();
                
                $user = $member_result->fetchArray(SQLITE3_ASSOC);
                
                if($user['Surface'] === 2){
                   
                    $sql_threads = "INSERT INTO Thread VALUES (:name,:date,:location,:LIMIT,:member_id); ";
                    
                    $stmt_threads = $conn->prepare($sql_threads);
                    
                    $stmt_threads->bindParam(":member_id",$Member_id);
                    $stmt_threads->bindParam(":location", $location,SQLITE3_TEXT);
                    $stmt_threads->bindParam(":name", $name,SQLITE3_TEXT);
                    $stmt_threads->bindParam(":LIMIT", $limit,SQLITE3_INTEGER);
                    $stmt_threads->bindParam(":date", $date,SQLITE3_TEXT);
                    
                    if($stmt_threads->execute()){
                        echo json_encode(array("status"=> "success","message"=> "successfully created an Event"));
                    }
                    else{
                        echo json_encode(array("status"=> "error","message"=> "Something Went wrong"));
                    }

                }
                else{
                    http_response_code(405);
                    $response = array('status' => 'error','message'=> 'authorized to create an Event');
                    echo json_encode($response);
                }
        }
        else {
            // Invalid request method
            http_response_code(405); // Method Not Allowed
            $response = array('status' => 'error', 'message' => 'Invalid request method');
            echo json_encode($response);
        }
    }
    }

?>