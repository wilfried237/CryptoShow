<?php
    require_once("./function/DBConnection.php");
    
    

    // this function generates a random hex color
    function random_hex_generator(): string {
        $finalString = "#";
        $hex = ["0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F"];
        for ($i = 0; $i <= 5; $i++) {
            $finalString .= $hex[random_int(0, sizeof($hex) - 1)];
        }
        return $finalString;
    }
    
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
                    $date = date('Y-m-d H:i:s');
                    $random_color = random_hex_generator();
                    $Color = $_POST['color'] ? $_POST['color']:  $random_color;
                    $hash_password = password_hash($password, PASSWORD_DEFAULT);
                    $conn = connection_to_Maria_DB();
                    
                    $sql = "INSERT INTO Member(Firstname, Lastname, Passwords, Email, Phone, Colour,Created_at) VALUES (:firstname, :lastname, :password, :email, :phone, :color,:created_at)";
                    $stmt = $conn->prepare($sql);
            
                    // Bind the named placeholders to variables
                    $stmt->bindParam(':firstname', $firstname);
                    $stmt->bindParam(':lastname', $lastname);
                    $stmt->bindParam(':phone', $phone);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':password', $hash_password);
                    $stmt->bindParam(':color', $Color);
                    $stmt->bindParam(':created_at', $date);

                    // Execute the statement and handle the result
                    if ($stmt->execute()) {
                        echo json_encode(array('status' => 'success', 'firstname' => $firstname));
                    } else {
                        echo json_encode(array('status' => 'error', 'message'=> 'failed to register'));
                    }
                }
                else{
                    http_response_code(401);
                    echo json_encode(array('status'=> 'error','message'=> 'need params'));
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
    
                $conn = connection_to_Maria_DB();
    
                $sql = 'SELECT * FROM Member WHERE Email = :email';
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':email', $email);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
                if($user && password_verify($password, $user['Passwords'])){
                    unset($user['Passwords']); // Remove password from returned data
                    echo json_encode(array('status' => 'success', 'user' => $user));
                } 
                elseif($user && $password === $user['Passwords']){
                    unset($user['Passwords']); // Remove password from returned data
                    echo json_encode(array('status' => 'success', 'user' => $user));
                }
                else {
                   // http_response_code(401);
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
    function show_all_member(): void {
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');
    
        $conn = connection_to_Maria_DB();
        $sql = "SELECT * FROM Member;";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        $user_hash_map = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Do something with the data in the row
            unset($row['Passwords']);
            $user_hash_map[$row['Member_id']] = $row;
        }
        
        echo json_encode(array("status" => "success", "users" => $user_hash_map));
    }
     

    // this function verifies if a user is a user
    function isMember(int $id,$connection_to_Maria_DB): array{
        $conn = $connection_to_Maria_DB;

        $member_sql = 'SELECT * FROM Member WHERE Member_id= :Member_id;';
        $member_stmt = $conn->prepare($member_sql);
        $member_stmt->bindValue(':Member_id', $id);
        $member_stmt->execute();
        $member = $member_stmt->fetch(PDO::FETCH_ASSOC);
        if($member){
            return array('status'=> true,'user'=> $member);
        }
        else{
            return array('status'=> false,'user'=> null);
        }
    }

    // this function allows the user to make some modification
    function update_user(): void{
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['member_id'])){
            
            // collecting member id
            $member_id = $_POST['member_id'];

            // connecting to the DB
            $conn = connection_to_Maria_DB();

            if(isMember($member_id,$conn)['status']){

            // collecting previous data of user
            $prev_member_info = isMember($member_id,$conn)['user'];

            // collect the form data
            $firstname = $_POST['Firstname']?$_POST['Firstname']: $prev_member_info['Firstname'];
            $lastname = $_POST['Lastname']? $_POST['Lastname'] : $prev_member_info['Lastname'];
            $phone = $_POST['Phone']?$_POST['Phone']: $prev_member_info['Phone'];
            $email = $_POST['Email']?$_POST['Email']: $prev_member_info['Email'];
            $password = $_POST['Password']||"" ?$_POST['Password'] : $prev_member_info['Passwords'];
            $created_at = $prev_member_info['Created_at'];
            $date = date('Y-m-d H:i:s');
            // $profilPic = $_POST['profilPic']?$_POST['profilPic'] : $prev_member_info['Profilepic'];

            $sql = 'UPDATE Member SET Firstname = :firstname, Lastname = :lastname, Email= :email, Phone= :phone, Passwords= :password,Created_at=:created_at,Updated_at= :update_date WHERE Member_id=:member_id;';
            $stmt = $conn->prepare($sql);
            
            // Bind the name placeholders to variables
            $stmt->bindValue(':member_id', $member_id);
            $stmt->bindValue(':firstname', $firstname);
            $stmt->bindValue(':lastname', $lastname);
            $stmt->bindValue(':phone', $phone);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':update_date', $date);
            $stmt->bindValue(':created_at', $created_at);
            $stmt->bindValue(':password', password_hash($password,PASSWORD_DEFAULT) );
            // $stmt->bindValue(':profilepic', $profilPic,SQLITE3_BLOB);

            if($stmt->execute()){
                $newUser = isMember($member_id,$conn)['user'];
                unset($newUser['Passwords']);
                echo json_encode(array('status' => 'success','message'=> 'successfully updated member','user'=> $newUser ));
            }else{
                //http_response_code(401);
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


    function getUser(): void {
        
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('Access-Control-Allow-Origin: http://localhost:8888');
            header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type');
            header('Content-Type: application/json');
            http_response_code(200);
            exit;
        }
    
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['Member_id'])) {
                $conn = connection_to_Maria_DB();
                $Member_id = $_POST['Member_id'];
                ['status'=>$status,  'user'=>$user_info] = isMember($Member_id, $conn);
                
                if ($status) {
                    unset($user_info['Passwords']);
                    echo json_encode(array('status' => 'success', 'user' => $user_info));
                } else {
                    http_response_code(401);
                    echo json_encode(array('status' => 'error', 'message' => 'User does not exist'));
                }
            } else {
                http_response_code(501);
                echo json_encode(array('status' => 'error', 'message' => 'Need Params'));
            }
        } else {
            http_response_code(500);
            echo json_encode(array('status' => 'error', 'message' => 'Invalid request'));
        }
    }
    
    function member_print(){
        
        if($_SERVER['REQUEST_METHOD']==='POST'){
            if(isset($_POST['Member_id'])){
                $Member_id = $_POST['Member_id'];
                $conn=connection_to_Maria_DB();
                $info = isMember($Member_id, connection_to_Sqlite_DB());
                
                if($info['status'] == true){
                    // $sql = 'SELECT Member_id, Firstname, Lastname, Email, Phone, Surface FROM Member WHERE Member_id = :Member_id;                    ';
                    // $member_stmt = $conn->prepare($sql);
                    // $member_stmt->bindValue(':Member_id', $Member_id);
                    // $member_result = $member_stmt->execute();
                    // $member = $member_result->fetchArray(SQLITE3_ASSOC);
                    $user=$info['user'];
                    unset($user['Passwords']);
                    echo json_encode(array($user));
                }
                else{
                    echo json_encode(array('message' => "Failed 3"));
                }
                
            }
            else{
                echo json_encode(array('message' => "Failed 2"));
            }
           

        }
        else{
            echo json_encode(array('message' => "Failed 1"));
        }
    }
?>