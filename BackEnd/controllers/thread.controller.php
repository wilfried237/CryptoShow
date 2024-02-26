<?php
    require("./function/DBConnection.php");
    require("./controllers/members.controller.php");

    // this function books an event
    function book_threads(){
        // Enable CORS for a specific origin
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['Member_id']) && isset($_POST['threads_id'])){
                
                 $member_id = $_POST['Member_id'];
                 $threads_id = $_POST['threads_id'];

                $conn = connection_to_Sqlite_DB();

                if(isMember($member_id)['status']){
                
                    if(isThread($threads_id)['status']){
                        $threads_member_1_sql = 'SELECT * FROM Thread_register WHERE Thread_id= :thread_id AND Member_id = :member_id';
                        $threads_member_1_stmt = $conn->prepare($threads_member_1_sql);
                        $threads_member_1_stmt->bindValue('thread_id',$threads_id);
                        $threads_member_1_stmt->bindValue(':member_id',$member_id);
                        $threads_member_1_result = $threads_member_1_stmt->execute();
                        $threads_member_1 = $threads_member_1_result->fetchArray(SQLITE3_ASSOC);
                       
                        if(!$threads_member_1){

                            $threads_member_2_sql = 'SELECT * FROM Thread_register WHERE Thread_id= :thread_id';

                            $threads_member_2_stmt = $conn->prepare($threads_member_2_sql);

                            $threads_member_2_stmt->bindValue('thread_id',$threads_id);

                            $threads_member_2_result = $threads_member_2_stmt->execute();

                            $threads_member_2_hash_map = array();

                            while($row = $threads_member_2_result->fetchArray(SQLITE3_ASSOC)){
                                array_push($threads_member_2_hash_map, $row);
                            }

                            if(count($threads_member_2_hash_map) < $threads['Limit']){

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
                            else{
                                echo json_encode(array('status'=> 'error','message'=>'Sorry Event is full'));
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

    // this function cancels an event
    function cancel_thread(){
        // Enable CORS for a specific origin
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['Member_id']) && isset($_POST['threads_id'])){
                $member_id = $_POST['Member_id'];
                $threads_id = $_POST['threads_id'];

                $conn = connection_to_Sqlite_DB();

                if(isMember($member_id)['status']){
                    
                    if(isThread($threads_id)['status']){
                        $threads_member_1_sql = 'SELECT * FROM Thread_register WHERE Thread_id= :thread_id AND Member_id = :member_id;';
                        $threads_member_1_stmt = $conn->prepare($threads_member_1_sql);
                        $threads_member_1_stmt->bindValue('thread_id',$threads_id);
                        $threads_member_1_stmt->bindValue(':member_id',$member_id);
                        $threads_member_1_result = $threads_member_1_stmt->execute();
                        $threads_member_1 = $threads_member_1_result->fetchArray(SQLITE3_ASSOC);
                       
                        if($threads_member_1){
                            $threads_member_sql = 'DELETE * FROM Thread_register WHERE Thread_id= :thread_id AND Member_id = :member_id;';
                            $threads_member_stmt = $conn->prepare($threads_member_sql);
                            $threads_member_stmt->bindParam(':Threads_id', $threads_id);
                            $threads_member_stmt->bindParam(':Member_id', $member_id);
    
                            if($threads_member_stmt->execute()){
                                echo json_encode(array('status'=> 'success','message'=> 'Cancel successfull'));
                            }
                            else{     
                                echo json_encode(array('status'=> 'error','message'=> 'Something when wrong, Cancel failed'));
                            }
                        }else{
                            http_response_code(401);
                            echo json_encode(array('status'=> 'error','message'=> 'You are not booked into this event'));
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
                    echo json_encode(array('status'=> 'error','message'=> 'user does not exist'));
                }
            }
            else{
                http_response_code(400);
                echo json_encode(array('status'=> 'error','message'=> 'Invalid Request'));
            }
        }
    }

    // this function shows all the events
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

    // this function verifies if a thread is a thread
    function isThread(int $thread_id): array{
        $conn = connection_to_Sqlite_DB();
        $threads_sql  = 'SELECT * FROM Thread WHERE Thread_id= :Thread_id;';
        $threads_stmt = $conn->prepare($threads_sql);
        $threads_stmt->bindValue(':Threads_id', $thread_id);
        $threads_result = $threads_stmt->execute();
        $threads = $threads_result->fetchArray(SQLITE3_ASSOC);
        if($threads){
            return array('status'=> true,'thread'=> $threads);
        }
        else{
            return array('status'=> false,'thread'=> null);
        }
    }
    
?>