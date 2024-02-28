<?php
    require_once("./function/DBConnection.php");
    require_once("./controllers/members.controller.php");

    // This function Creates a threads
    function create_threads(): void {
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['name']) && isset($_POST['location']) && isset($_POST['Member_id'])) {
                
                $name = $_POST['name'];
                $location = $_POST['location'];
                $Member_id = $_POST['Member_id'];
                $date = date("h:i:sa");
                $limit = isset($_POST['limit']) ? $_POST['limit'] : 15;
                $conn = connection_to_Sqlite_DB();
                
                if (isOrganizer($Member_id)) {
                    
                    $sql_threads = "INSERT INTO Thread(Thread_name, Thread_date, Venue, `Limit`, Member_id) VALUES (:name, :date, :location, :limit, :member_id);";

                    $stmt_threads = $conn->prepare($sql_threads);
                    
                    $stmt_threads->bindValue(":member_id", $Member_id, SQLITE3_INTEGER);
                    $stmt_threads->bindValue(":location", $location, SQLITE3_TEXT);
                    $stmt_threads->bindValue(":name", $name, SQLITE3_TEXT);
                    $stmt_threads->bindValue(":limit", $limit, SQLITE3_INTEGER);
                    $stmt_threads->bindValue(":date", $date, SQLITE3_TEXT);
                    
                    
                    if ($stmt_threads->execute()) {
                        echo json_encode(array("status" => "success", "message" => "Successfully created an Event"));
                    } else {
                        http_response_code(500);
                        echo json_encode(array("status" => "error", "message" => "Something went wrong"));
                    }
    
                } else {
                    http_response_code(405);
                    $response = array('status' => 'error', 'message' => 'Unauthorized to create an Event');
                    echo json_encode($response);
                }
            } else {
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
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');

        
        if($_SERVER['REQUEST_METHOD']==="POST"){
            if(isset($_POST["Member_id"])){
                // store variable
                $member_id = $_POST["Member_id"];
                $conn = connection_to_Sqlite_DB();
                if(isMember($member_id, $conn)['status']){
                    if(isOrganizer($member_id)){
                        $date = date("h:i:sa");
                        $sql = "INSERT INTO Organiser_list VALUES (:member_id, :date);";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindValue(":member_id", $member_id,SQLITE3_INTEGER);
                        $stmt->bindValue(":date", $date, SQLITE3_TEXT);
                        if($stmt->execute()){
                            echo json_encode(array("status"=> "success","message"=> "Request send awaiting approval"));
                        }else{
                            http_response_code(500);
                            $response = array("status"=> "error", "message"=> "Something went wrong");
                            echo json_encode($response);
                        }
                    }else{
                        http_response_code(401);
                        $response = array('status'=> 'error','message'=> 'You are already an Organizer');
                    }
                }
                else{
                    http_response_code(401);
                    echo json_encode(array('status'=> 'error','message'=> 'Member does not exist'));
                }
            }
            else{
                http_response_code(500);
                $response = array("status"=> "error","message"=> "Wrong request need id");
                echo json_encode($response);
            }
        }
        else{
            http_response_code(500);
            echo json_encode(array("status"=> "error","message"=> "Wrong request"));
        }
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
    function isOrganizer(int $organizer_id): bool {
        $conn = connection_to_Sqlite_DB();
        $surface = 2;
        $organizer_sql = 'SELECT * FROM Member WHERE Member_id = :organizer_id AND Surface = :surface;';
        $organizer_stmt = $conn->prepare($organizer_sql);
        $organizer_stmt->bindValue(':organizer_id', $organizer_id);
        $organizer_stmt->bindValue(':surface', $surface, SQLITE3_INTEGER);
    
        $organizer_result = $organizer_stmt->execute();
        $organizer = $organizer_result->fetchArray(SQLITE3_ASSOC);
    
        if ($organizer) {
            return true;
        } else {
            return false;
        }
    }
    

?>