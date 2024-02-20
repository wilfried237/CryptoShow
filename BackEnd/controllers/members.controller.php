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
                    
                    $conn = connection_to_database();
                    
                    $sql = "INSERT INTO person(FN, LNE, PSW, EML, PN) VALUES (:firstname, :lastname, :password, :email, :phone)";
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
                        echo json_encode(array('status' => 'error', 'message' => $stmt->errorInfo()));
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

        if($_SERVER['REQUEST_METHOD']==='GET'){
            $email = $_GET['email'];
            $password = $_GET['password'];
            $conn = connection_to_database();
            $sql = 'SELECT * FROM person WHERE EML ='.$email.'AND PSW ='.$password.' LIMIT 1';
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                
            } else {
                http_response_code(405);
                $response = array('status'=> 'success','message'=> 'User Not found');
                echo json_encode($response);
            }
            // $stmt = $conn->prepare($sql);
            // $stmt->bindParam(':email', $email);
            // $stmt->bindParam(':password', $password);
            // $stmt->execute();
            // $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // if($row){}

        }
    }
    function show_all_member(){
        echo "show all members paths ";
        $conn = connection_to_database();
        $sql = "SELECT * FROM members";
        $result = $conn->query($sql);
            while ($row = $result->fetch())
            {
                print_r($row);
                foreach ($row as $key => $value) {
                    echo "$key: $value <br>";
                }
                echo $row['PN'];
            }
    }
?>