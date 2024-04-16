<?php
    require_once("./function/DBConnection.php");
    require_once("./controllers/members.controller.php");
    require_once("./controllers/thread.controller.php");
    
    function register_device(){
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Check if the POST request contains the expected form fields
                if(isset($_POST['Member_id']) && isset($_POST['Thread_id']) && isset($_POST['Device_name'])) {
                    $Member_id = $_POST['Member_id'];
                    $Thread_id = $_POST['Thread_id'];
                    $Device_name = $_POST['Device_name'];
                    $Device_Image = $_POST['Device_image']? $_POST['Device_image'] : "https://www.eclosio.ong/wp-content/uploads/2018/08/default.png";
                    $Device_description = $_POST['Device_description']? $_POST['Device_description']: null ;
                    $conn = connection_to_Maria_DB();
                    ['status'=>$status,'thread'=> $thread] = isThread($Thread_id,$conn);
                    if($status){
                        if(isMember($Member_id,$conn)['status']){
    
                            // Device does not exist, proceed with the insertion
                            $sql = "INSERT INTO device (Device_id, Member_id, Thread_id, Device_name, Device_image, Device_description) VALUES (:Device_id, :Member_id, :Thread_id, :Device_name, :DeviceImage, :DeviceDesc);";
                            $stmt = $conn->prepare($sql);
    
                            // Bind the named placeholders to variables
                            $stmt->bindParam(':Device_id', $Device_id);
                            $stmt->bindParam(':Member_id', $Member_id);
                            $stmt->bindParam(':Thread_id', $Thread_id);
                            $stmt->bindParam(':Device_name', $Device_name);
                            $stmt->bindParam(':DeviceImage', $Device_Image);
                            $stmt->bindParam(':DeviceDesc', $Device_description);
    
                            // Execute the statement and handle the result
                            if ($stmt->execute()) {
                                echo json_encode(array('status' => 'success', 'message' => $Device_name . ' registered to Thread: ' . $thread['Thread_name']));
                            } else {
                                echo json_encode(array('status' => 'error', 'message'=> 'failed to register device'));
                            }
                        }
                        else{
                            http_response_code(401);
                            echo json_encode(array('status'=> 'error','message'=> 'Not a valid Member'));
                        }
                    }
                    else{
                        http_response_code(401);
                        echo json_encode(array('status'=> 'error','message'=> 'Not a valid Thread'));
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

        if($_SERVER['REQUEST_METHOD']==="POST"){
            if(isset($_POST["thread_id"]) && isset($_POST["device_id"]) && isset($_POST["Organizer_id"])){
                $organizer_id = $_POST["Organizer_id"];
                $device_id = $_POST["device_id"];
                $thread_id = $_POST["thread_id"];
                $conn = connection_to_Maria_DB();
                if(isThreadCreator($organizer_id, $thread_id, $conn)['status']){
                        $sql = 'DELETE FROM device WHERE Device_id=:device_id;';
                        $organizer_stmt = $conn->prepare($sql);

                        // Bind parameters
                        $organizer_stmt->bindValue(":device_id",$device_id);

                        if($organizer_stmt->execute()){
                            echo json_encode(['status'=>"success", 'message'=>"Successfully Deleted Device"]);
                        }
                        else{
                            http_response_code(401);
                            echo json_encode(['status'=>"error","message"=> "unsuccessful to Deleted Device"]);
                        }
                }
                else{
                    $response = array("status" => "error", "message" => "You are not a valid Organizer");
                    echo json_encode($response);
                }
            }
            else{
                http_response_code(400);
                $response = array("status" => "error", "message" => "Wrong request, need Member_id, Organizer_id, and thread_id");
                echo json_encode($response);
            }
        }
        else{
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "Wrong request method, only POST is allowed"));
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