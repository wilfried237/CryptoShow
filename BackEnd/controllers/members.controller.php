<?php
    require("./function/DBConnection.php");
    
    function register_member(){
        // Enable CORS for a specific origin
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Check if the POST request contains the expected form fields
                if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['phone']) && isset($_POST['password']) && isset($_POST['email'])) {
                // Collect the form data
                    $firstname = $_POST['firstname'];
                    $lastname = $_POST['lastname'];
                    $phone = $_POST['phone'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    
                    $conn = connection_to_Sqlite_DB();
                    
                    $sql = "INSERT INTO Member(Firstname, Lastname, Passwords, Email, Phone) VALUES (:firstname, :lastname, :password, :email, :phone)";
                    $stmt = $conn->prepare($sql);
            
                    // Bind the named placeholders to variables
                    $stmt->bindParam(':firstname', $firstname);
                    $stmt->bindParam(':lastname', $lastname);
                    $stmt->bindParam(':phone', $phone);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':password', $password);
            
                    // Execute the statement and handle the result
                    if ($stmt->execute()) {
                        echo json_encode(array('status' => 'success', 'firstname' => $firstname));
                    } else {
                        echo json_encode(array('status' => 'error' ));
                    }
                }
        } 
        
        else {
            // Invalid request method
            http_response_code(405); // Method Not Allowed
            $response = array('status' => 'error', 'message' => 'Invalid request method');
            echo json_encode($response);
        }

    }
    function login_member(){
        // Enable CORS for a specific origin
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');
    
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['email']) && isset($_POST['password'])){
                $email = $_POST['email'];
                $password = $_POST['password'];
    
                $conn = connection_to_Sqlite_DB();
    
                $sql = 'SELECT * FROM Member WHERE Email = :email';
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':email', $email, SQLITE3_TEXT);
                $result = $stmt->execute();
                $user = $result->fetchArray(SQLITE3_ASSOC);
    
                if($user && $password===$user['Passwords']){
                    unset($user['Passwords']); // Remove password from returned data
                    echo json_encode(array('status' => 'success', 'user' => $user));
                } else {
                    http_response_code(401);
                    $response = array('status' => 'error', 'message' => 'User email or password not correct');
                    echo json_encode($response);
                }
            }
            else {
                http_response_code(400); // Bad Request
                $response = array('status' => 'error', 'message' => 'Invalid email or password');
                echo json_encode($response);
            }
        }
    }
    
    function show_all_member(){

        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');

        $conn = connection_to_Sqlite_DB();
        $sql = "SELECT * FROM Member;";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute();
        $user_hash_map = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            // Do something with the data in the row
            unset($row['Passwords']);
            $user_hash_map[$row['Member_id']] = $row;
        }
        
        echo json_encode(array("status"=> "success","users"=> $user_hash_map));
    }   

    function book_threads(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['Member_id']) && isset($_POST['threads_id'])){
                
                $member_id = $_POST['Member_id'];
                $threads_id = $_POST['threads_id'];

                $conn = connection_to_Sqlite_DB();

                $member_sql = 'SELECT * FROM Member WHERE Member_id= :Member_id;';
                $member_stmt = $conn->prepare($member_sql);
                $member_stmt->bindValue(':Member_id', $member_id);
                $member_result = $member_stmt->execute();
                $member = $member_result->fetchArray(SQLITE3_ASSOC);
                if($member){
                    $threads_sql  = 'SELECT * FROM Thread WHERE Thread_id= :Thread_id;';
                    $threads_stmt = $conn->prepare($threads_sql);
                    $threads_stmt->bindValue(':Threads_id', $threads_id);
                    $threads_result = $threads_stmt->execute();
                    $threads = $threads_result->fetchArray(SQLITE3_ASSOC);
                    
                    if($threads){
                        $threads_member_1_sql = 'SELECT * FROM Thread_register WHERE Thread_id= :thread_id AND Member_id = :member_id';
                        $threads_member_1_stmt = $conn->prepare($threads_member_1_sql);
                        $threads_member_1_stmt->bindValue('thread_id',$threads_id);
                        $threads_member_1_stmt->bindValue(':member_id',$member_id);
                        $threads_member_1_result = $threads_member_1_stmt->execute();
                        $threads_member_1 = $threads_member_1_result->fetchArray(SQLITE3_ASSOC);
                       
                        if(!$threads_member_1){

                            if($threads['Threads'])
                            {
                                $threads_member_sql = 'INSERT INTO Thread_register VALUES (:Threads_id,:Member_id)';
                                $threads_member_stmt = $conn->prepare($threads_member_sql);
                                $threads_member_stmt->bindParam(':Threads_id', $threads_id);
                                $threads_member_stmt->bindParam(':Member_id', $member_id);
        
                                if($threads_member_stmt->execute()){
                                    echo json_encode(array('status'=> 'success','message'=> 'Booking is successfull'));
                                }
                                else{     
                                    echo json_encode(array('status'=> 'error','message'=> 'Something when wrong, Booking failed'));
                                }
                            }

                        }
                        else{
                            http_response_code(401);
                            echo json_encode(array('status'=> 'error','message'=> 'You are already booked into the system'));
                        }

                    }
                    else{
                        http_response_code(401);
                        $response = array('status'=> 'error','message'=> 'Thread do not exist');
                        echo json_encode($response);
                    }
                }
                else{
                    http_response_code(401);
                    $response = array('status'=> 'error','message'=> 'User do not exist');
                    echo json_encode($response);
                }

            }   
            else{
                http_response_code(400); // Bad Request
                $response = array('status' => 'error', 'message' => 'Invalid Request');
                echo json_encode($response);
            }
        }
    }

    function show_all_threads(){
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');

        $conn = connection_to_Sqlite_DB();
        $sql = 'SELECT * FROM Threads';
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute();
        $threads_hash_map = [];

        while($row = $result->fetchArray(SQLITE3_ASSOC)){
            $threads_hash_map[$row['Thread_id']] = $row;
        }
        echo json_encode(array('status' => 'success', 'Threads'=> $threads_hash_map));
    }
?>