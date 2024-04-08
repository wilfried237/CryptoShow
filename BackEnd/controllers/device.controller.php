<?php
    require_once("./function/DBConnection.php");
    
    
    function register_device(){
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
            //Invalid request method, return error
            http_response_code(405); 
            echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
            return;
        }
        else {
            //Checks for required parameters
            $requiredParams = array('Device_id', 'Member_id', 'Thread_id', 'Device_name');
            foreach ($requiredParams as $param) {
                if (!isset($_POST[$param]) || empty($_POST[$param])) {
                    //If any required parameter is missing or empty, return error
                    http_response_code(401);
                    echo json_encode(array('status' => 'error', 'message' => 'Empty or missing parameters'));
                    return;
                }
            }
    
            //Collect the form data
            $Device_id = intval($_POST['Device_id']);
            $Member_id = intval($_POST['Member_id']);
            $Thread_id = intval($_POST['Thread_id']);
            $Device_name = htmlspecialchars($_POST['Device_name']);
    
            //Get current timestamp
            $date = date('Y-m-d H:i:s');
    
            //Connect to MariaDB
            $conn = connection_to_Maria_DB();
    
            //Check if the device already exists in the database
            $sql_check = "SELECT COUNT(*) FROM Device WHERE Device_id = :Device_id";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bindParam(':Device_id', $Device_id);
            $stmt_check->execute();
            $count = $stmt_check->fetchColumn();
    
            if ($count > 0) {
                //Device already exists, handle the situation accordingly
                echo json_encode(array('status' => 'error', 'message' => 'Device already exists'));
            } else {
                //Device does not exist, proceed with the insertion
                $sql = "INSERT INTO Device(Device_id, Member_id, Thread_id, Device_name, Device_registered_timestamp) VALUES (:Device_id, :Member_id, :Thread_id, :Device_name, :Device_registered_timestamp)";
                $stmt = $conn->prepare($sql);
    
                //Bind the named placeholders to variables
                $stmt->bindParam(':Device_id', $Device_id, PDO::PARAM_INT);
                $stmt->bindParam(':Member_id', $Member_id, PDO::PARAM_INT);
                $stmt->bindParam(':Thread_id', $Thread_id, PDO::PARAM_INT);
                $stmt->bindParam(':Device_name', $Device_name, PDO::PARAM_STR);
                $stmt->bindParam(':Device_registered_timestamp', $date);
    
                //Execute the statement and handle the result
                if ($stmt->execute()) {
                    echo json_encode(array('status' => 'success', 'message' => $Device_name . ' registered to Thread: ' . $Thread_id));
                } else {
                    echo json_encode(array('status' => 'error', 'message'=> 'Failed to register device'));
                }
            }
        } 
    }

    function delete_device(){
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');
        
        if($_SERVER['REQUEST_METHOD']!=='POST'){
            http_response_code(405);
            echo json_encode(array('status'=>'error', 'message'=>'Invalid request method'));
        }
        $requiredParams = array('Device_id', 'Member_id');
        foreach ($requiredParams as $param) {
            if (!isset($_POST[$param]) || empty($_POST[$param])) {
                http_response_code(401);
                echo json_encode(array('status' => 'error', 'message' => 'Empty or missing parameters'));
                return;
            }
        }
                $Member_id = intval($_POST['Member_id']);
                $Device_id = intval($_POST['Device_id']);


                
                $conn=connection_to_Maria_DB();

                $sql = 'DELETE FROM Member_devices WHERE Device_id = :Device_id AND Member_id = :Member_id;
                    DELETE FROM Device WHERE Device_id = :Device_id AND Member_id = :Member_id;';

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':Member_id', $Member_id, PDO::PARAM_INT);
                $stmt->bindParam(':Device_id', $Device_id, PDO::PARAM_INT);

                if($stmt->execute()){
                   echo json_encode(array('Succesfully deleted device ' . $Device_id));

                    }
                    else{
                        echo json_encode(array('status'=>'error','message'=>'Unsuccesful'));
                    }
                


        }

    /*function edit_device(){
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check if the POST request contains the expected form fields
            if ((isset($_POST['Device_id']) && (isset($_POST['Member_id']) || isset($_POST['Thread_id']) || isset($_POST['Device_name']) || isset($_POST['Device_image']) || isset($_POST['Device_description']))) ||
            (isset($_POST['Device_id']) && isset($_POST['Member_id']) && (isset($_POST['Thread_id'])|| isset($_POST['Device_name']) || isset($_POST['Device_image']) || isset($_POST['Device_description']))) ||
            (isset($_POST['Device_id']) && isset($_POST['Thread_id']) && (isset($_POST['Device_name']) || isset($_POST['Device_image']) || isset($_POST['Device_description']))) ||
            (isset($_POST['Device_id']) && isset($_POST['Device_name']) && (isset($_POST['Device_image']) || isset($_POST['Device_description']))) || 
            (isset($_POST['Device_id']) && isset($_POST['Device_image']) && isset($_POST['Device_description'])) ||    
            (isset($_POST['Device_id']) && isset($_POST['Member_id']) && isset($_POST['Thread_id']) && 
            (isset($_POST['Device_name']) || isset($_POST['Device_image']) || isset($_POST['Device_description']))) || 
            (isset($_POST['Device_id']) && isset($_POST['Member_id']) && isset($_POST['Device_name']) && 
            (isset($_POST['Device_image']) || isset($_POST['Device_description']))) || 
            (isset($_POST['Device_id']) && isset($_POST['Member_id']) && isset($_POST['Device_image']) && isset($_POST['Device_description'])) || 
            (isset($_POST['Device_id']) && isset($_POST['Member_id']) && isset($_POST['Thread_id']) && isset($_POST['Device_name']) && 
            (isset($_POST['Device_image']) || isset($_POST['Device_description']))) || 
            (isset($_POST['Device_id']) && isset($_POST['Member_id']) && isset($_POST['Thread_id']) && isset($_POST['Device_name']) && 
            isset($_POST['Device_image']) && isset($_POST['Device_description']))) {
            
                // Collect the form data
                $Device_id = $_POST['Device_id'];
                $Member_id = $_POST['Member_id'];
                $Thread_id = $_POST['Thread_id'];
                $Device_name = $_POST['Device_name'];
                $Device_image = $_POST['Device_image'];
                $Device_description = $_POST['Device_dscription'];
                
                $date = date('Y-m-d H:i:s');

                $conn = connection_to_Maria_DB();

                $sql = "UPDATE Device 
                        SET 
                            Member_id = :Member_id, 
                            Thread_id = :Thread_id, 
                            Device_name = :Device_name, 
                            Device_image = :Device_image, 
                            Device_description = :Device_description, 
                            Device_updated_at = :Device_updated_at
                        WHERE 
                            Device_id = :Device_id";


                $stmt = $conn->prepare($sql);

                // Bind the named placeholders to variables
                $stmt->bindParam(':Device_id', $Device_id);
                $stmt->bindParam(':Member_id', $Member_id);
                $stmt->bindParam(':Thread_id', $Thread_id);
                $stmt->bindParam(':Device_name', $Device_name);
                $stmt->bindParam(':Device_image', $Device_image);
                $stmt->bindParam(':Device_description', $Device_description);
                $stmt->bindParam(':Device_updated_at', $date);

                // Execute the statement and handle the result
                if ($stmt->execute()) {
                    echo json_encode(array('status' => 'success', 'message' => $Device_name . ' has been updated'));
                } else {
                    echo json_encode(array('status' => 'error', 'message'=> 'failed to update device'));
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
}*/

function edit_device() {
    // Set CORS headers
    header('Access-Control-Allow-Origin: http://localhost:8888');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    header('Content-Type: application/json');

    // Ensure the request method is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405); // Method Not Allowed
        echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
        return;
    }

    // Check if required parameters are present
    $requiredParams = array('Device_id', 'Member_id', 'Thread_id', 'Device_name', 'Device_image', 'Device_description');
    foreach ($requiredParams as $param) {
        if (!isset($_POST[$param]) || empty($_POST[$param])) {
            http_response_code(401);
            echo json_encode(array('status' => 'error', 'message' => 'Missing or empty required parameter: ' . $param));
            return;
        }
    }

    // Validate input data (e.g., ensure integer values)
    $Device_id = intval($_POST['Device_id']);
    $Member_id = intval($_POST['Member_id']);
    $Thread_id = intval($_POST['Thread_id']);
    // Additional validation can be added for other fields

    // Collect other sanitized form data
    $Device_name = htmlspecialchars($_POST['Device_name']);
    $Device_image = htmlspecialchars($_POST['Device_image']);
    $Device_description = htmlspecialchars($_POST['Device_description']);

    // Connect to the database
    $conn = connection_to_Maria_DB();

    // Prepare and execute the SQL statement
    $sql = "UPDATE Device 
            SET 
                Member_id = :Member_id, 
                Thread_id = :Thread_id, 
                Device_name = :Device_name, 
                Device_image = :Device_image, 
                Device_description = :Device_description, 
                Device_updated_at = :Device_updated_at
            WHERE 
                Device_id = :Device_id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':Device_id', $Device_id, PDO::PARAM_INT);
    $stmt->bindParam(':Member_id', $Member_id, PDO::PARAM_INT);
    $stmt->bindParam(':Thread_id', $Thread_id, PDO::PARAM_INT);
    $stmt->bindParam(':Device_name', $Device_name, PDO::PARAM_STR);
    $stmt->bindParam(':Device_image', $Device_image, PDO::PARAM_STR);
    $stmt->bindParam(':Device_description', $Device_description, PDO::PARAM_STR);
    $stmt->bindValue(':Device_updated_at', date('Y-m-d H:i:s'), PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo json_encode(array('status' => 'success', 'message' => $Device_name . ' has been updated'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Failed to update device'));
    }
}

?>
