<?php
    require("./function/DBConnection.php");

    // This function Creates a threads
    function create_threads():void{
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
                $color = isset($_POST['color']) || null;
                $conn = connection_to_Sqlite_DB();
                
                if(isOrganizer($Member_id)){
                   
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

    // this function makes a request to the admin in order for 
    // a user to be upgraded from surface 3 to 2
    function request_level_up():void{

    }

    // this function shows all organisers
    function show_all_organisers():void{
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');

        $surface = 2;

        $conn = connection_to_Sqlite_DB();
        $sql = 'SELECT * FROM Member WHERE Surface=:surface_id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':surface_id', $surface, SQLITE3_INTEGER);
        $result = $stmt->execute();
        $organiser_hash_map = array();
        while($row = $result->fetchArray(SQLITE3_ASSOC)){
            unset($row['Passwords']);
            array_push($organiser_hash_map, $row);
        }
        echo json_encode(array("status"=> "success","users"=> $organiser_hash_map));
    }

    // this function updates the information from an event
    function update_thread():void{

    }

    // this function deletes a particular 
    function delete_thread():void{

    }

    // this function deletes a member which is an event
    function delete_member_thread():void{

    }

    // this function shows all members belonging to a particular event
    function view_member_thread():void{

    }

    // this function checks if an organizer is an organizer
    function isOrganizer(int $organizer_id):bool{
        $conn = connection_to_Sqlite_DB();
        $surface = 2;
        $organizer_sql = 'SELECT * FROM Member WHERE Member_id= :organizer_id AND Surface =:surface;';
        $organizer_stmt = $conn->prepare($organizer_sql);
        $organizer_stmt->bindValue(':Member_id', $organizer_id);
        $organizer_stmt->bindValue(':surface', $surface, SQLITE3_INTEGER);

        $organizer_result = $organizer_stmt->execute();
        $organizer = $organizer_result->fetchArray(SQLITE3_ASSOC);
        if($organizer){
            return true;
        }
        else{
            return false;
        }
    }

?>