<?php
    require_once("./function/DBConnection.php");

    function delete_user(){
        //Allows requests from http://localhost:8888
        header('Access-Control-Allow-Origin: http://localhost:8888');
        //Specifies allowed HTTP methods
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        //Specifies allowed headers
        header('Access-Control-Allow-Headers: Content-Type');
        //Sets response content type to JSON
        header('Content-Type: application/json');
        
        //Checks if request method is POST
        if($_SERVER['REQUEST_METHOD']!=='POST'){
            //If not post return error
            http_response_code(405);
            echo json_encode(array('status'=>'error', 'message'=>'Invalid request method'));
            return;
        }
        else{
            //Assings required parameters to an array
            $requiredParams = array('Member_id','Surface');
            //Loops through the above array
            foreach($requiredParams as $param){
                //Checks that the parameters given and not empty
                if(!isset($_POST[$param])||empty($_POST[$param])){
                    http_response_code(401);
                    echo json_encode(array('status'=>'error','message'=>'Empty or missing parameters'));
                    return;
                }
            }
                //Converts value recieved from parameters to integer then assigns it to variables
                //If any of the values given are not integer, varaible will be set to 0
                $Member_id = intval($_POST['Member_id']);
                $Surface = intval($_POST['Surface']);

                //Checks that the user is admin / surface is 1
                if($Surface == 1){

                    //Creating a variable for the function which connects to the Database
                    $conn=connection_to_Maria_DB();

                    //Creates the SQL query to delete user and related data
                     $sql = 'DELETE FROM Member_devices WHERE Member_id = :Member_id;
                        DELETE FROM Thread_register WHERE Member_id = :Member_id;
                        DELETE FROM Thread WHERE Member_id = :Member_id;
                        DELETE FROM Device WHERE Member_id = :Member_id;
                        DELETE FROM Member WHERE Member_id = :Member_id;';

                    //Prepares the SQL query
                    $stmt = $conn->prepare($sql);

                    //Binds parameter to placeholder within prepared statement and specifies that parameter is an integer
                    $stmt->bindParam(':Member_id',$Member_id, PDO::PARAM_INT);

                    //Executes the sql statement and checks if it was succesful
                    if($stmt->execute()){
                        echo json_encode(array('Succesfully deleted member and all linked information'));

                    }
                    else{
                        echo json_encode(array('status'=>'error','message'=>'Unsuccesful'));
                    }
                }
                else{
                    echo json_encode(array('status'=>'error','message'=>"You are not authorised to delete members"));
                }

            }
        }
        
    

    function delete_organiser(){

    }

    function update_organiser(){
        
    }

    function upgrade_organiser(){
        //Allows requests from http://localhost:8888
        header('Access-Control-Allow-Origin: http://localhost:8888');
        //Specifies allowed HTTP methods
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        //Specifies allowed headers
        header('Access-Control-Allow-Headers: Content-Type');
        //Sets response content type to JSON
        header('Content-Type: application/json');

        //Checks if request method is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            //Returns error if not a POST request
            http_response_code(405);
            echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
            return;
        } else {
            //Assings required parameters to an array
            $requiredParams = array('Member_id','Surface');
            //Loops through the above array
            foreach($requiredParams as $param){
                //Checks that the parameters given and not empty
                if(!isset($_POST[$param])||empty($_POST[$param])){
                    http_response_code(401);
                    echo json_encode(array('status'=>'error','message'=>'Empty or missing parameters'));
                    return;
                }
            }
                //Converts parameter values to integers
                //If any value is not an integer, it will be set to 0
                $Member_id = intval($_POST['Member_id']);
                $Surface = intval($_POST['Surface']);

                //Checks that the user is an admin
                if ($Surface == 1) {

                    //Creating a variable for the function which connects to the Database
                    $conn = connection_to_Maria_DB();

                    //Creates the SQL query which updates the member's Surface to 2
                    $sql = 'UPDATE Member SET Surface = 2 WHERE Member_id = :Member_id';
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':Member_id', $Member_id, PDO::PARAM_INT);

                    // Execute the SQL statement and check if successful
                    if ($stmt->execute()) {
                        echo json_encode(array('status' => 'success', 'message' => 'Successfully upgraded member to organiser'));
                    } else {
                        echo json_encode(array('status' => 'error', 'message' => 'Unsuccessful'));
                    }
                } else {
                    echo json_encode(array('status' => 'error', 'message' => 'You are not authorized to perform this action'));
                }
            }
        }
    
    function downgrade_organiser(){
        //Allows requests from http://localhost:8888
        header('Access-Control-Allow-Origin: http://localhost:8888');
        //Specifies allowed HTTP methods
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        //Specifies allowed headers
        header('Access-Control-Allow-Headers: Content-Type');
        //Sets response content type to JSON
        header('Content-Type: application/json');

        //Checks if request method is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            //Return error if not a POST request
            http_response_code(405);
            echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
        } else {
            
            //Assings required parameters to an array
            $requiredParams = array('Member_id','Surface');
            //Loops through the above array
            foreach($requiredParams as $param){
                //Checks that the parameters given and not empty
                if(!isset($_POST[$param])||empty($_POST[$param])){
                    http_response_code(401);
                    echo json_encode(array('status'=>'error','message'=>'Empty or missing parameters'));
                    return;
                }
            }
                //Converts value received from parameters to integer and assigns it to variables
                //If any of the values given are not integers, variable will be set to 0
                $Member_id = intval($_POST['Member_id']);
                $Surface = intval($_POST['Surface']);

                //Checks that the user is an admin
                if ($Surface == 1) {

                    //Creates a variable for the function which connects to the database
                    $conn = connection_to_Sqlite_DB();

                    //Creates SQL query to update member's surface to 3
                    $sql = 'UPDATE Member SET Surface = 3 WHERE Member_id = :Member_id';
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(':Member_id', $Member_id, PDO::PARAM_INT);

                    //Executes the SQL statement and checks if it's successful
                    if ($stmt->execute()) {
                        echo json_encode(array('Succesfully downgraded to member'));
                    } else {
                        echo json_encode(array('Unsuccesful'));
                    }
                } else {
                    echo json_encode(array('status' => 'error', 'message' => 'You do not have the authority to perform this action'));
                }
            }
        }
  
    

    function thread_list(){
        //Allows requests from http://localhost:8888
        header('Access-Control-Allow-Origin: http://localhost:8888');
        //Specifies allowed HTTP methods
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        //Specifies allowed headers
        header('Access-Control-Allow-Headers: Content-Type');
        //Sets response content type to JSON
        header('Content-Type: application/json');

        //Checks if request method is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { 
            
            //Returns error if not a POST request
            http_response_code(405);
            echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
            return;
        } else {
            
            //Assings required parameters to an array
            $requiredParams = array('Thread_id','Surface');
            //Loops through the above array
            foreach($requiredParams as $param){
                //Checks that the parameters given and not empty
                if(!isset($_POST[$param])||empty($_POST[$param])){
                    http_response_code(401);
                    echo json_encode(array('status'=>'error','message'=>'Empty or missing parameters'));
                    return;
                }
            }
                
                //Converts value received from parameters to integer and assigns it to variables
                //If any of the values given are not integers, variable will be set to 0
                $thread_id = intval($_POST['Thread_id']);
                $Surface = intval($_POST['Surface']);

                //Checks if user is an organiser
                if ($Surface == 1) {

                    //Creates a variable for the function which connects to the database
                    $conn = connection_to_Maria_DB();

                    //Retrieves members registered to the specified thread
                    $sql = 'SELECT Member_id FROM Thread_register WHERE Thread_id = :Thread_id';
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(':Thread_id', $thread_id, PDO::PARAM_INT);

                    //Executes the SQL statement and checks if successful
                    if ($stmt->execute()) {
                        if ($stmt->rowCount() > 0) {
                            //Fetches all members registered to the thread
                            $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            echo json_encode(array('members' => $members));
                        } else {
                            echo json_encode(array('status' => 'error', 'message' => 'No members registered to this thread'));
                        }
                    }
                    else {
                        echo json_encode(array('Unsuccesful'));
                    }
                }
                else {
                    echo json_encode(array('status' => 'error', 'message' => 'You do not have the authority to perform this action'));
                }
            
        }

    }

    function show_organisers(){
        show_all_organisers();
    }

    function show_members(){
        show_all_member();
    }

    function show_devices(){
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');
        
        //connect to databse
        $conn = connection_to_Maria_DB();
        //selects all from device table
        $sql = 'SELECT * FROM Device;';
        //prepare and execute sql statement
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        //create hashmap to store devices
        $device_hash_map = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            //fill hashmap
            array_push($device_hash_map, $row);
        }
        echo json_encode(array("status"=> "success","users"=> $device_hash_map));
    }

    function show_all_messages(){
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');
        
        //connection to database
        $conn = connection_to_Maria_DB();
        //selects all from all_messages table
        $sql = 'SELECT * FROM All_messages;';
        //prepare and execute sql statement
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        //create hashmap to store messages
        $message_hash_map = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            //fill hashmap
            array_push($message_hash_map, $row);
        }
        echo json_encode(array("status"=> "success","users"=> $message_hash_map));
    }

    function show_member_messages(){
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');
        
        //if request method is post proceed else show error
        if($_SERVER['REQUEST_METHOD']!=='POST'){
            http_response_code(405);
            echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
            return;
        }
        //if user posts member_id proceed else show error
        if(!isset($_POST['Member_id'])||empty($_POST['Member_id'])){
            http_response_code(401);
            echo json_encode(array('status'=>'error','message'=>'Empty or missing parameters'));
            return;
        }

        //create variable for member_id
        $Member_id = intval($_POST['Member_id']);
        //connect to database
        $conn = connection_to_Maria_DB();
        //select all from all_messages with the selected member_id
        $sql = 'SELECT * FROM All_messages WHERE Member_id = :Member_id;';
        //prepare sql statement
        $stmt = $conn->prepare($sql);
        //bind placeholder member_id to variable member_id
        $stmt->bindValue(':Member_id', $Member_id, PDO::PARAM_INT);
        //execure sql statement
        $stmt->execute();
        //create hashmap to store messages
        $message_hash_map = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            //fill hashmap
            array_push($message_hash_map, $row);
        }
        echo json_encode(array("status"=> "success","users"=> $message_hash_map));
    }

    function delete_member_messages(){
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');
        
        //if request method is post proceed else show error
        if($_SERVER['REQUEST_METHOD']!=='POST'){
            http_response_code(405);
            echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
            return;
        }
        //if user posts Message_id proceed else show error
        if(!isset($_POST['Message_id'])||empty($_POST['Message_id'])){
            http_response_code(401);
            echo json_encode(array('status'=>'error','message'=>'Empty or missing parameters'));
            return;
        }

        //create variable for Message_id
        $Message_id = intval($_POST['Message_id']);
        //connect to database
        $conn = connection_to_Maria_DB();
        //delete from all_messages  and message with the selected member_id
        $sql = 'DELETE FROM All_messages WHERE Message_id = :Message_id;';
        //prepare sql statement
        $stmt = $conn->prepare($sql);
        //bind placeholder message_id to variable message
        $stmt->bindValue(':Message_id', $Message_id, PDO::PARAM_INT);
        
        //execure sql statement
        if($stmt->execute()){
            $sql2 = 'DELETE FROM message WHERE Message_id = :Message_id;';
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bindValue(':Message_id', $Message_id, PDO::PARAM_INT);
            if($stmt2->execute()){
                echo json_encode(array("status"=>"Message deleted from message and all_messages successfully"));
            }
            else{
                echo json_encode(array("status"=>"message deleted from all_messages but not from message"));
            }
        }
        else{
            echo json_encode(array("status"=> "message not deleted from all_messages or message table"));
        }

    }

function show_member_devices(){
    header('Access-Control-Allow-Origin: http://localhost:8888');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    header('Content-Type: application/json');

    //if request method is post proceed else show error
    if($_SERVER['REQUEST_METHOD']!=='POST'){
        http_response_code(405);
        echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
        return;
    }
    //if user posts member_id proceed else show error
    if(!isset($_POST['Member_id'])||empty($_POST['Member_id'])){
        http_response_code(401);
        echo json_encode(array('status'=>'error','message'=>'Empty or missing parameters'));
        return;
    }
    //create variable for member_id
    $Member_id = intval($_POST['Member_id']);
    //connect to database
    $conn = connection_to_Maria_DB();
    //select all from device with the selected member_id
    $sql = 'SELECT * FROM Device WHERE Member_id = :Member_id;';
    //prepare sql statement
    $stmt = $conn->prepare($sql);
    //bind placeholder member_id to variable member_id
    $stmt->bindValue(':Member_id', $Member_id, PDO::PARAM_INT);
    //execure sql statement
    $stmt->execute();
    //create hashmap to store messages
    $device_hash_map = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        //fill hashmap
        array_push($device_hash_map, $row);
    }
    echo json_encode(array("status"=> "success","users"=> $device_hash_map));
}

function show_thread_devices(){
    header('Access-Control-Allow-Origin: http://localhost:8888');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    header('Content-Type: application/json');

    //if request method is post proceed else show error
    if($_SERVER['REQUEST_METHOD']!=='POST'){
        http_response_code(405);
        echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
        return;
    }
    //if user posts thread_id proceed else show error
    if(!isset($_POST['Thread_id'])||empty($_POST['Thread_id'])){
        http_response_code(401);
        echo json_encode(array('status'=>'error','message'=>'Empty or missing parameters'));
        return;
    }
    //create variable for thread_id
    $Thread_id = intval($_POST['Thread_id']);
    //connect to database
    $conn = connection_to_Maria_DB();
    //select all from device with the selected thread_id
    $sql = 'SELECT * FROM Device WHERE Thread_id = :Thread_id;';
    //prepare sql statement
    $stmt = $conn->prepare($sql);
    //bind placeholder thread_id to variable thread_id
    $stmt->bindValue(':Thread_id', $Thread_id, PDO::PARAM_INT);
    //execure sql statement
    $stmt->execute();
    //create hashmap to store messages
    $device_hash_map = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        //fill hashmap
        array_push($device_hash_map, $row);
    }
    echo json_encode(array("status"=> "success","users"=> $device_hash_map));
}

?>