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
                $image = $_POST['image'] ? $_POST['image'] : "https://www.eclosio.ong/wp-content/uploads/2018/08/default.png";
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
    


    // this function returns the number of device a member registered in a thread
    function number_devices(){
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');
    
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            if(isset($_POST["Member_id"]) && isset($_POST["Organizer_id"]) && isset($_POST["thread_id"])){
                $organizer_id = $_POST["Organizer_id"];
                $member_id = $_POST["Member_id"];
                $thread_id = $_POST["thread_id"];
                $conn = connection_to_Maria_DB();
    
                if(isThreadCreator($organizer_id, $thread_id, $conn)['status']){
                    if(isMember($member_id, $conn)['status']){
                        $sql = 'SELECT COUNT(*) as device_count FROM device WHERE Member_id = :Member_id AND Thread_id = :thread_id';
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':Member_id', $member_id);
                        $stmt->bindParam(':thread_id', $thread_id);
                        $stmt->execute();
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                        $device_count = $result['device_count'];
    
                        $response = array("status" => "success", "device_count" => $device_count);
                        echo json_encode($response);
                    } else {
                        $response = array("status" => "error", "message" => "Not a valid Member");
                        echo json_encode($response);
                    }
                } else {
                    $response = array("status" => "error", "message" => "You are not a valid Organizer");
                    echo json_encode($response);
                }
            } else {
                http_response_code(400);
                $response = array("status" => "error", "message" => "Wrong request, need Member_id, Organizer_id, and thread_id");
                echo json_encode($response);
            }
        } else {
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "Wrong request method, only POST is allowed"));
        }
    }
    

    // this function returns all the devices a member registered into a thread
    function get_member_device():void{
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');
    
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            if(isset($_POST["Member_id"]) && isset($_POST["Organizer_id"]) && isset($_POST["thread_id"])){
                $organizer_id = $_POST["Organizer_id"];
                $member_id = $_POST["Member_id"];
                $thread_id = $_POST["thread_id"];
                $conn = connection_to_Maria_DB();
    
                if(isThreadCreator($organizer_id, $thread_id, $conn)['status']){
                    if(isMember($member_id, $conn)['status']){
                        $sql = 'SELECT * FROM device WHERE Member_id = :Member_id AND Thread_id = :thread_id';
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':Member_id', $member_id);
                        $stmt->bindParam(':thread_id', $thread_id);
                        $stmt->execute();
                        $device_hash_map = [];
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                            array_push($device_hash_map, $row);
                        }
                        echo json_encode(array("status"=> "success","devices"=> $device_hash_map));
                    } else {
                        $response = array("status" => "error", "message" => "Not a valid Member");
                        echo json_encode($response);
                    }
                } else {
                    $response = array("status" => "error", "message" => "You are not a valid Organizer");
                    echo json_encode($response);
                }
            } else {
                http_response_code(400);
                $response = array("status" => "error", "message" => "Wrong request, need Member_id, Organizer_id, and thread_id");
                echo json_encode($response);
            }
        } else {
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "Wrong request method, only POST is allowed"));
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
            if(isset($_POST["thread_id"]) && isset($_POST["Member_id"])){
                $thread_id = $_POST["thread_id"];
                $member_id = $_POST["Member_id"];
                
                $conn = connection_to_Maria_DB();

                if(isThread($thread_id, $conn)['status']){
                    
                    if(isMember($member_id,$conn)){

                        // verifies if the organizer is the thread creator
                        if(isThreadCreator($member_id,$thread_id,$conn)["status"]){
                            
                            // verify if the organizer is the one who created the event
                            $organizer_sql = "SELECT * FROM Thread WHERE Thread_id = :thread_id AND Member_id = :member_id;";
                            $organizer_stmt = $conn->prepare($organizer_sql);

                            // Bind parameters
                            $organizer_stmt->bindValue(":thread_id",$thread_id);
                            $organizer_stmt->bindValue(":member_id",$member_id);

                            $organizer_stmt->execute();
                            $correspond_organizer = $organizer_stmt->fetch(PDO::FETCH_ASSOC);

                            if($correspond_organizer){
                                
                                // collecting data from user
                                ['thread'=>$prev_thread_info] =  isThread($thread_id, $conn);
                                $name       = isset($_POST["name"] )       ? $_POST["name"]        : $prev_thread_info["Thread_name"];
                                $location   = isset($_POST["location"]   ) ? $_POST["location"]    : $prev_thread_info["Venue"];
                                $limit      = isset($_POST["limit"]      ) ? $_POST["limit"]       : $prev_thread_info["Limit"];
                                $date       = isset($_POST["date"]       ) ? $_POST["date"]        : $prev_thread_info["Thread_date"];
                                $description= isset($_POST["description"]) ? $_POST["description"] : $prev_thread_info["Thread_description"];
                                $image      = isset($_POST["image"]      ) ? $_POST["image"]       : $prev_thread_info["Thread_image"];
                                $updated_at = date('Y-m-d H:i:s');
                                
                                $update_organizer_sql = "UPDATE Thread SET Thread_name = :name, Thread_date = :date, Thread_description = :description, Venue = :location, `Limit` = :limit, Thread_image = :image, Updated_at = :updated_at WHERE Thread_id = :thread_id AND Member_id = :member_id;";

                                $update_organizer_stmt = $conn->prepare($update_organizer_sql);

                                // Bind the name placeholders to variables
                                $update_organizer_stmt->bindValue(':name', $name);
                                $update_organizer_stmt->bindValue(':date', $date);
                                $update_organizer_stmt->bindValue(':description', $description);
                                $update_organizer_stmt->bindValue(':location', $location);
                                $update_organizer_stmt->bindValue(':limit', $limit);
                                $update_organizer_stmt->bindValue(':image', $image);
                                $update_organizer_stmt->bindValue(':updated_at', $updated_at);
                                $update_organizer_stmt->bindValue(':thread_id', $thread_id);
                                $update_organizer_stmt->bindValue(':member_id', $member_id);

                                    

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

        if($_SERVER['REQUEST_METHOD']==="POST"){
            if(isset($_POST["thread_id"]) && isset($_POST["Member_id"])){

                // binning data
                $thread_id = $_POST["thread_id"];
                $member_id = $_POST["Member_id"];
                $conn      = connection_to_Maria_DB();

                //organizer verification
                if(isOrganizer($member_id)){
                    ['status'=>$threadStatus, 'thread'=>$threadInfo] = isThread($thread_id,$conn);
                    if($threadStatus){
                        // verifies if the organizer is the thread creator
                        if(isThreadCreator($member_id,$thread_id,$conn)["status"]){
                            $organizer_sql = "DELETE FROM thread_register WHERE Thread_id=:thread_id;
                            DELETE FROM device WHERE Thread_id=:thread_id;
                            DELETE FROM thread WHERE Thread_id=:thread_id;
                            ";
                            $organizer_stmt = $conn->prepare($organizer_sql);

                            // Bind parameters
                            $organizer_stmt->bindValue(":thread_id",$threadInfo["Thread_id"]);

                            if($organizer_stmt->execute()){
                                echo json_encode(['status'=>"success", 'message'=>"Successfully Deleted Thread"]);
                            }
                            else{
                                http_response_code(401);
                                echo json_encode(['status'=>"error","message"=> "unsuccessful to Deleted Thread"]);
                            }
                        }
                        else{
                            http_response_code(401);
                            echo json_encode(array("status"=>"error", "message"=>"unauthorized you are not the creator of this Thread"));
                        }

                    }
                    else{
                        http_response_code(401);
                        echo json_encode(array("status"=>"error", "message"=>"Thread does not exist"));
                    }
                }
                else{
                    http_response_code(401);
                    echo json_encode(array("status"=>"error", "message"=>"You are not a valid organizer"));
                }
            }
            else{
                http_response_code(500);
                echo json_encode(array("status"=>"error", "message"=>"require id"));
            }
        }
        else{
            http_response_code(500);
            echo json_encode(array("status"=> "error","message"=> "Wrong request"));
        }

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

    // this function deletes a member which is in an event
    function delete_member_thread():void{
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');

        if($_SERVER['REQUEST_METHOD']==="POST"){
            if(isset($_POST["thread_id"]) && isset($_POST["Member_id"]) && isset($_POST["Organizer_id"])){
                $conn = connection_to_Maria_DB();

                //storing variables
                $thread_id = $_POST["thread_id"];
                $member_id = $_POST["Member_id"];
                $organizer_id = $_POST["Organizer_id"];
                if(isThread($thread_id, $conn)["status"]){
                    if(isThreadCreator($organizer_id ,$thread_id,$conn)["status"]){
                        $organizer_sql = " DELETE FROM device WHERE Member_id=:member_id AND Thread_id=:thread_id;
                                           DELETE FROM thread_register WHERE Member_id=:member_id AND Thread_id=:thread_id;
                        ";
                        $organizer_stmt = $conn->prepare($organizer_sql);

                        // Bind parameters
                        $organizer_stmt->bindValue(":thread_id",$thread_id);
                        $organizer_stmt->bindValue(":member_id",$member_id);

                        if($organizer_stmt->execute()){
                            echo json_encode(['status'=>"success", 'message'=>"Successfully Deleted Member"]);
                        }
                        else{
                            echo json_encode(['status'=>"error", 'message'=>"Unable to delete member"]);
                        }
                    }
                    else{
                        http_response_code(401);
                        echo json_encode(array("status"=>"error", "message"=>"unauthorized you are not the creator of this Thread"));
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
            echo json_encode(["status"=> "error","message"=> "Wrong request"]);
        }
    }

    /**
     * 
     * @author Wilfried Kamdoum <kamdoumwilfried8@gmail.com>
     * 
     
     */
    // this function verifies if an organizer is the one who created a particular thread
    function isThreadCreator(int $organizerID, int $threadID, PDO $conn):array{
        if(isThread($threadID, $conn)['status']){
            if(isOrganizer($organizerID)){
                
                $organizer_sql = "SELECT * FROM Thread WHERE Thread_id = :thread_id AND Member_id = :member_id;";
                $organizer_stmt = $conn->prepare($organizer_sql);

                // Bind parameters
                $organizer_stmt->bindValue(":thread_id",$threadID);
                $organizer_stmt->bindValue(":member_id",$organizerID);

                $organizer_stmt->execute();
                $correspond_organizer = $organizer_stmt->fetch(PDO::FETCH_ASSOC);

                if($correspond_organizer){
                    return ["status"=>true, "user"=>null];
                }
                else{
                    return ["status"=>false, "user"=>null];
                }

            }
            else{
                return ["status"=>false, "user"=>null];
            }
        }
        else{
            return ["status"=>false, "user"=>null];
        }
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