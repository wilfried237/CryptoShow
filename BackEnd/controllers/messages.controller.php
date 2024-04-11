<?php
    require_once("./function/DBConnection.php");
    require_once("./controllers/members.controller.php");
    require_once("./controllers/organiser.controller.php");


    function send_messages(){

        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');
    
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            //If not post return error
            http_response_code(405);
            echo json_encode(array('status'=>'error', 'message'=>'Invalid request method'));
            return;
        }
        else{
            //Assings required parameters to an array
            $requiredParams = array('Sender_id','Recipient_id','Message_title','Message_desc');
            //Loops through the above array
            foreach($requiredParams as $param){
                //Checks that the parameters given and not empty
                if(!isset($_POST[$param]) || empty($_POST[$param])){
                    http_response_code(401);
                    echo json_encode(array('status'=>'error','message'=>'Empty or missing parameters'));
                    return;
                }
            }
            //Converts value received from parameters to integer then assigns it to variables
            //If any of the values given are not integer, variable will be set to 0
    
            $Sender_id = intval($_POST['Sender_id']);
            $Recipient_id = intval($_POST['Recipient_id']);
            $Message_title = htmlspecialchars($_POST['Message_title']);
            $Message_desc = htmlspecialchars($_POST['Message_desc']);
            $date = date('Y-m-d H:i:s');
            $conn = connection_to_Maria_DB();
            
            //Prepare sql statement and bind parameters
            $sql = "INSERT INTO Message(Message_title, Message_desc, Sender_id, Recipient_id, Created_at) VALUES (:Message_title, :Message_desc, :Sender_id, :Recipient_id, :Created_at);";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':Sender_id', $Sender_id);
            $stmt->bindParam(':Recipient_id', $Recipient_id);
            $stmt->bindParam(':Message_title', $Message_title);
            $stmt->bindParam(':Message_desc', $Message_desc);
            $stmt->bindParam(':Created_at', $date);
    
            if($stmt->execute()){

                echo json_encode(array('status'=>'success','message'=>'Succesful'));
                $Message_id = $conn->lastInsertId();

                // Prepare SQL statement to insert message into All_messages table
                $sql_insert_all_messages = "INSERT INTO All_messages (Member_id, Message_id, Message_title, Message_desc) VALUES (:Member_id, :Message_id, :Message_title, :Message_desc);";
                $stmt_insert_all_messages = $conn->prepare($sql_insert_all_messages);
                $stmt_insert_all_messages->bindParam(':Member_id', $Sender_id); // Assuming the sender is the member who sent the message
                $stmt_insert_all_messages->bindParam(':Message_id', $Message_id);
                $stmt_insert_all_messages->bindParam(':Message_title', $Message_title);
                $stmt_insert_all_messages->bindParam(':Message_desc', $Message_desc);

                // Execute the insert statement for All_messages table
                if ($stmt_insert_all_messages->execute()) {
                    echo json_encode(array('status'=>'success','message'=>'Final part succesful'));
                } else {
                    echo json_encode(array('error'=>'success','message'=>'Final part unsuccesful'));
                }
                // Get the last inserted message ID
                /*$message_id = $conn->lastInsertId();
                
                // Insert into All_messages table
                $sql_insert_all_messages = "INSERT INTO All_messages(Message_id, Sender_id, Recipient_id, Message_title, Message_desc, Created_at) VALUES (:Message_id, :Sender_id, :Recipient_id, :Message_title, :Message_desc, :Created_at);";
                $stmt_insert_all_messages = $conn->prepare($sql_insert_all_messages);
                $stmt_insert_all_messages->bindParam(':Message_id', $message_id);
                $stmt_insert_all_messages->bindParam(':Sender_id', $Sender_id);
                $stmt_insert_all_messages->bindParam(':Recipient_id', $Recipient_id);
                $stmt_insert_all_messages->bindParam(':Message_title', $Message_title);
                $stmt_insert_all_messages->bindParam(':Message_desc', $Message_desc);
                $stmt_insert_all_messages->bindParam(':Created_at', $date);
    
                if($stmt_insert_all_messages->execute()){
                    echo json_encode(array('status'=>'success','message'=>'Successful', 'message_id' => $message_id));
                }
                else{
                    echo json_encode(array('status'=>'error','message'=>'Unsuccessful'));
                }*/
            }
            else{
                echo json_encode(array('status'=>'error','message'=>'Unsuccessful'));
            }
        }
    }
    

?>