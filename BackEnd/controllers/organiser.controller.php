<?php
    require_once("./function/DBConnection.php");
    require_once("./controllers/members.controller.php");
    require_once("./controllers/thread.controller.php");

    // This function Creates a threads
    function create_threads(): void {
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['name']) && isset($_POST['location']) && isset($_POST['Member_id']) && isset($_POST['date'])) {
                
                $name = $_POST['name'];
                $location = $_POST['location'];
                $Member_id = $_POST['Member_id'];
                $date = $_POST['date'];
                $image = $_POST['image'] ? $_POST['image'] : null;
                $description = $_POST['description'] ? $_POST['description'] : null;
                $limit = isset($_POST['limit']) ? $_POST['limit'] : 15;

                $conn = connection_to_Maria_DB();
                
                if (isOrganizer($Member_id)) {
                    
                    $sql_threads = "INSERT INTO Thread(Thread_name, Thread_date, Venue, `Limit`, Member_id,Thread_image,Thread_description) VALUES (:name, :date, :location, :limit, :member_id,:image,:description);";

                    $stmt_threads = $conn->prepare($sql_threads);
                    
                    $stmt_threads->bindValue(":member_id", $Member_id);
                    $stmt_threads->bindValue(":location", $location);
                    $stmt_threads->bindValue(":name", $name);
                    $stmt_threads->bindValue(":limit", $limit);
                    $stmt_threads->bindValue(":date", $date);
                    $stmt_threads->bindValue(":image",$image);
                    $stmt_threads->bindValue(":description",$description);
                    
                    
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
                $conn = connection_to_Maria_DB();
                if(isMember($member_id, $conn)['status']){
                    if(isOrganizer($member_id)){
                        $date = date("h:i:sa");
                        $sql = "INSERT INTO Organiser_list VALUES (:member_id, :date);";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindValue(":member_id", $member_id);
                        $stmt->bindValue(":date", $date);
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

        $conn = connection_to_Maria_DB();
        $sql = 'SELECT * FROM Member WHERE Surface=:surface_id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':surface_id', $surface);
        $stmt->execute();
        $organiser_hash_map = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            unset($row['Passwords']);
            array_push($organiser_hash_map, $row);
        }
        echo json_encode(array("status"=> "success","users"=> $organiser_hash_map));
    }

    // this function updates the information from an event
    function update_thread():void{
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD']==="POST"){
            if(isset($_POST["thread_id"])&& isset($_POST["member_id"])){
                $thread_id = $_POST["thread_id"];
                $member_id = $_POST["member_id"];
                
                $conn = connection_to_Maria_DB();

                if(isThread($thread_id, $conn)['status']){
                    
                    if(isMember($member_id,$conn)){

                        if(isOrganizer($member_id)){
                            
                            // verify if the organizer is the one who created the event
                            $organizer_sql = "SELECT * FROM Thread WHERE Thread_id = :thread_id AND Member_id = :member_id;";
                            $organizer_stmt = $conn->prepare($organizer_sql);

                            // Bind parameters
                            $organizer_stmt->bindValue(":thread_id",$thread_id,SQLITE3_INTEGER);
                            $organizer_stmt->bindValue(":member_id",$member_id,SQLITE3_INTEGER);

                            $organizer_stmt->execute();
                            $correspond_organizer = $organizer_stmt->fetch(PDO::FETCH_ASSOC);

                            if($correspond_organizer){
                                
                                // collecting data from user
                                $ThreadInfo =  isThread($thread_id, $conn)['thread'];
                                $name  = $_POST["thread_name"]? $_POST["thread_name"] : $ThreadInfo["Thread_name"] ;
                                $location = $_POST["location"]? $_POST["location"] : $ThreadInfo["Venue"] ;
                                $limit = $_POST["limit"]? $_POST["limit"] : $ThreadInfo["Limit"] ;

                                $update_organizer_sql = " UPDATE Thread SET Thread_name= :name , Venue= :location, Limit= :limit WHERE Thread_id= :thread_id AND Member_id= :member_id; ";
                                $update_organizer_stmt = $conn->prepare($update_organizer_sql);

                                // Bind the name placeholders to variables
                                $update_organizer_stmt->bindValue(':name',$name,SQLITE3_TEXT);
                                $update_organizer_stmt->bindValue(':location',$location,SQLITE3_TEXT);
                                $update_organizer_stmt->bindValue(':limit',$limit,SQLITE3_INTEGER);
                                $update_organizer_stmt->bindValue(':thread_id',$thread_id,SQLITE3_INTEGER);
                                $update_organizer_stmt->bindValue(':member_id',$member_id,SQLITE3_INTEGER);      

                                if($update_organizer_stmt->execute()){
                                    echo json_encode(array('status'=>"success", 'message'=>"Successfully modified Thread"));
                                }
                                else{
                                    http_response_code(401);
                                    echo json_encode(array('status'=>"error","message"=> "unsuccessful to modify Thread"));
                                }
                            }

                            else{
                                http_response_code(401);
                                echo json_encode(array("status"=>"error", "message"=>"unauthorized you are not the creator of this Thread"));
                            }

                        }

                        else{
                            http_response_code(401);
                            echo json_encode(array("status"=>"error", "message"=>"You are not a valid organizer"));
                        }

                    }

                    else{
                        http_response_code(401);
                        echo json_encode(array("status"=>"error", "message"=>"You are not a member"));
                    }
                }

                else{
                    http_response_code(401);
                    echo json_encode(array("status"=>"error", "message"=>"Thread does not exist"));
                }

            }
            
            else{
                http_response_code(500);
                echo json_encode(array("status"=>"error", "message"=>"require id"));
            }

        }

        else{
            http_response_code(500);
            echo json_encode(array("status"=>"error","message"=>"Bad request"));
        }

    }

    // this function deletes a particular thread
    function delete_thread():void{
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');
    }

    // this function shows all the threads created by a particular organizer
    function show_threads_organizer():void{
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');

        if($_SERVER['REQUEST_METHOD']==="POST"){
            if(isset($_POST["Member_id"])){
                // storing variable obtained from Post Request
                $Member_id = $_POST["Member_id"];
                if(isOrganizer($Member_id)){

                    $conn = connection_to_Maria_DB();

                    $sql = "SELECT * FROM thread WHERE Member_id= :Member_id;";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(":Member_id", $Member_id);
                    $stmt->execute();
                    $threads_hash_map = [];
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $threads_hash_map[$row["Thread_id"]] = $row;
                    }
                    echo json_encode(array("status"=> "success","threads"=> $threads_hash_map));
                }
                else{
                    echo json_encode(array("status"=> "error","message"=> "You are not eligible"));
                }
            }
            else{
                echo json_encode(array("status"=> "error","message"=> "Require a Member Id"));
            }
        }else{
            echo json_encode(array("status"=> "error","message"=> "Request Method Not Correct"));
        }
    }
    // this function deletes a member which is an event
    function delete_member_thread():void{

    }

    // this function shows all members belonging to a particular event
    function view_member_thread():void{

    }

    // this function checks if an organizer is an organizer
    function isOrganizer(int $organizer_id): bool {
        $conn = connection_to_Maria_DB();
        $surface = 2;
        $organizer_sql = 'SELECT * FROM Member WHERE Member_id = :organizer_id AND Surface = :surface;';
        $organizer_stmt = $conn->prepare($organizer_sql);
        $organizer_stmt->bindValue(':organizer_id', $organizer_id);
        $organizer_stmt->bindValue(':surface', $surface, SQLITE3_INTEGER);
    
        $organizer_stmt->execute();
        $organizer = $organizer_stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($organizer) {
            return true;
        } else {
            return false;
        }
    }
    

?>