<?php
    require_once("./function/DBConnection.php");
    
    
    function register_device(){
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Check if the POST request contains the expected form fields
                if(isset($_POST['Device_id']) && isset($_POST['Member_id']) && isset($_POST['Thread_id']) && isset($_POST['Device_name'])) {
                
                    // Collect the form data
                    $Device_id = $_POST['Device_id'];
                    $Member_id = $_POST['Member_id'];
                    $Thread_id = $_POST['Thread_id'];
                    $Device_name = $_POST['Device_name'];
                    
                    $date = date('Y-m-d H:i:s');

                    $conn = connection_to_Maria_DB();

                    // Check if the device already exists in the database
                    $sql_check = "SELECT COUNT(*) FROM Device WHERE Device_id = :Device_id";
                    $stmt_check = $conn->prepare($sql_check);
                    $stmt_check->bindParam(':Device_id', $Device_id);
                    $stmt_check->execute();
                    $count = $stmt_check->fetchColumn();

                    if ($count > 0) {
                        // Device already exists, handle the situation accordingly
                        echo json_encode(array('status' => 'error', 'message' => 'Device already exists'));
                    } else {
                        // Device does not exist, proceed with the insertion
                        $sql = "INSERT INTO Device(Device_id, Member_id, Thread_id, Device_name, Device_registered_timestamp) VALUES (:Device_id, :Member_id, :Thread_id, :Device_name, :Device_registered_timestamp)";
                        $stmt = $conn->prepare($sql);

                        // Bind the named placeholders to variables
                        $stmt->bindParam(':Device_id', $Device_id);
                        $stmt->bindParam(':Member_id', $Member_id);
                        $stmt->bindParam(':Thread_id', $Thread_id);
                        $stmt->bindParam(':Device_name', $Device_name);
                        $stmt->bindParam(':Device_registered_timestamp', $date);

                        // Execute the statement and handle the result
                        if ($stmt->execute()) {
                            echo json_encode(array('status' => 'success', 'message' => $Device_name . ' registered to Thread: ' . $Thread_id));
                        } else {
                            echo json_encode(array('status' => 'error', 'message'=> 'failed to register device'));
                        }
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

    function delete_device(){
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');
        
        if($_SERVER['REQUEST_METHOD']==='POST'){
            if(isset($_POST['Device_id']) && isset($_POST['Member_id'])){
                $Member_id = $_POST['Member_id'];
                $Device_id = $_POST['Device_id'];


                
                $conn=connection_to_Maria_DB();

                $sql = 'DELETE FROM Member_devices WHERE Device_id = :Device_id AND Member_id = :Member_id;
                    DELETE FROM Device WHERE Device_id = :Device_id AND Member_id = :Member_id;';

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':Member_id', $Member_id);
                $stmt->bindParam(':Device_id', $Device_id);

                if($stmt->execute()){
                   echo json_encode(array('Succesfully deleted device ' . $Device_id));

                    }
                    else{
                        echo json_encode(array('status'=>'error','message'=>'Unsuccesful'));
                    }
                }
                else{
                    echo json_encode(array('status'=>'error','message'=>"You are not authorised to delete this device"));
                }

            }
            else{
                echo json_encode(array('status'=>'error','message'=>"Invalid Member_id or Device_id"));
            }
        }

    function edit_device(){
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
    }