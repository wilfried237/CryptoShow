<?php
    require("./function/DBConnection.php");
    
    // this function registers a new member into the DB
    function register_member(): void{
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
                    $Color = $_POST['color'] || null;
                    
                    $conn = connection_to_Sqlite_DB();
                    
                    $sql = "INSERT INTO Member(Firstname, Lastname, Passwords, Email, Phone, Colour) VALUES (:firstname, :lastname, :password, :email, :phone, :color)";
                    $stmt = $conn->prepare($sql);
            
                    // Bind the named placeholders to variables
                    $stmt->bindParam(':firstname', $firstname);
                    $stmt->bindParam(':lastname', $lastname);
                    $stmt->bindParam(':phone', $phone);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':password', $password);
                    $stmt->bindParam(':color', $Color);

                    // Execute the statement and handle the result
                    if ($stmt->execute()) {
                        echo json_encode(array('status' => 'success', 'firstname' => $firstname));
                    } else {
                        echo json_encode(array('status' => 'error', 'message'=> 'failed to register'));
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

    // this function login a new member into the system
    function login_member(): void{
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
    
    // this function shows all the members
    function show_all_member():void{

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

    // this function verifies if a user is a user
    function isMember(int $id): array{
        $conn = connection_to_Sqlite_DB();

        $member_sql = 'SELECT * FROM Member WHERE Member_id= :Member_id;';
        $member_stmt = $conn->prepare($member_sql);
        $member_stmt->bindValue(':Member_id', $id);
        $member_result = $member_stmt->execute();
        $member = $member_result->fetchArray(SQLITE3_ASSOC);
        if($member){
            return array('status'=> true,'user'=> $member);
        }
        else{
            return array('status'=> false,'user'=> null);
        }
    }

    // this function allows the user to make some modification
    function update_user(): void{
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['member_id'])){
            
            // collecting member id
            $member_id = $_POST['member_id'];

            // connecting to the DB
            $conn = connection_to_Sqlite_DB();

            if(isMember($member_id)['status']){

            // collecting previous data of user
            $prev_member_info = isMember($member_id)['user'];

            // collect the form data
            $firstname = $_POST['firstname'] || $prev_member_info['Firstname'];
            $lastname = $_POST['lastname'] || $prev_member_info['Lastname'];
            $phone = $_POST['phone'] || $prev_member_info['Phone'];
            $email = $_POST['email'] || $prev_member_info['Email'];
            $password = $_POST['password'] || $prev_member_info['Passwords'];
            $profilPic = $_POST['profilPic'] || $prev_member_info['Profilepic'];

            $sql = 'UPDATE Member SET Firstname = :firstname, Lastname = :lastname, Email= :email, Phone= :phone, Passwords= :password, Profilepic= :profilepic WHERE Member_id=:member_id;';
            $stmt = $conn->prepare($sql);
            
            // Bind the name placeholders to variables
            $stmt->bindValue(':member_id', $member_id);
            $stmt->bindValue(':firstname', $firstname);
            $stmt->bindValue(':lastname', $lastname);
            $stmt->bindValue(':phone', $phone);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':password', $password);
            $stmt->bindValue(':profilepic', $profilPic,SQLITE3_BLOB);
            if($stmt->execute()){
                echo json_encode(array('status' => 'success','message'=> 'successfully updated member'));
            }else{
                echo json_encode(array('status' => 'error','message'=> 'failed to update member'));
            }
            }
            else{
                http_response_code(401);
                echo json_encode(array('status'=> 'error','message'=> 'User does not exist'));
            }



            }else{
                http_response_code(500);
                echo json_encode(array('status'=> 'error','message'=> 'Invalid request'));
            }
        }
    }
?>