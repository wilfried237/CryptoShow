<?php
    require_once("./function/DBConnection.php");

    function delete_user(){
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');
        
        if($_SERVER['REQUEST_METHOD']==='POST'){
            if(isset($_POST['Member_id']) && isset($_POST['Surface'])){
                $Member_id = $_POST['Member_id'];
                $Surface = $_POST['Surface'];

                if($Surface == 1){

                    $conn=connection_to_Maria_DB();

                     $sql = 'DELETE FROM Member_devices WHERE Member_id = :Member_id;
                        DELETE FROM Thread_register WHERE Member_id = :Member_id;
                        DELETE FROM Thread WHERE Member_id = :Member_id;
                        DELETE FROM Device WHERE Member_id = :Member_id;
                        DELETE FROM Member WHERE Member_id = :Member_id;';

                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':Member_id',$Member_id);

                    if($stmt->execute()){
                        echo json_encode(array('Successfully deleted member and all linked information'));

                    }
                    else{
                        echo json_encode(array('status'=>'error','message'=>'Unsuccessful'));
                    }
                }
                else{
                    echo json_encode(array('status'=>'error','message'=>"You are not authorised to delete members"));
                }

            }
            else{
                echo json_encode(array('status'=>'error','message'=>"Invalid Member_id or Surface"));
            }
        }
        
    }

    function delete_organiser(){

    }

    function update_organiser(){

    }

    function upgrade_organiser(){
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');
        
        echo json_encode(array('message'=>"HELLO"));
        if($_SERVER['REQUEST_METHOD']==='POST'){
            if(isset($_POST['Member_id']) && isset($_POST['Surface'])){
                $Member_id = $_POST['Member_id'];
                $Surface = $_POST['Surface'];

                if($Surface == 1){
                    
                    $conn=connection_to_Maria_DB();

                    $sql = 'UPDATE Member SET Surface = 2 WHERE Member_id = :Member_id';
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':Member_id',$Member_id);

                    if($stmt->execute()){
                        echo json_encode(array('Succesfully upgraded member to organiser'));
                    }
                    else{
                        echo json_encode(array('Unsuccesful'));
                    }
                }
                else{
                    echo json_encode(array('staus'=>'error', 'message'=>'You are not authorised to perform this action'));
                }
                

            }
            else{
                echo json_encode(array('message'=>"Failed 2"));
            }
        }
        else{
            echo json_encode(array('message'=>"Failed 1"));
        }
    }
    function downgrade_organiser(){
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');
        
        echo json_encode(array('message'=>"HELLO"));
        if($_SERVER['REQUEST_METHOD']==='POST'){
            if(isset($_POST['Member_id']) && isset($_POST['Surface'])){
                $Member_id = $_POST['Member_id'];
                $Surface = $_POST['Surface'];

                if($Surface == 1){
                    $conn=connection_to_Sqlite_DB();

                    $sql = 'UPDATE Member SET Surface = 3 WHERE Member_id = :Member_id';
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(':Member_id',$Member_id);

                    if($stmt->execute()){
                        echo json_encode(array('Succesfully downgraded to member'));
                    }
                    else{
                        echo json_encode(array('Unsuccesful'));
                    }
                }
                else{
                    echo json_encode(array('status'=>'error', 'message'=>'You do not have the authority to perform this action'));
                }

            }
            else{
                echo json_encode(array('message'=>"Failed 2"));
            }
        }
        else{
            echo json_encode(array('message'=>"Failed 1"));
        }
    }

    function thread_list(){
        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');

        if($_SERVER['REQUEST_METHOD']==='POST'){ 
            if(isset($_POST['Thread_id']) && isset($_POST['Surface'])){
                $thread_id=$_POST['Thread_id'];
                $Surface = $_POST['Surface'];

                if($Surface == 1){
                    $conn = connection_to_Maria_DB();

                    $sql='SELECT Member_id FROM Thread_register WHERE Thread_id = :Thread_id';
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(':Thread_id',$thread_id);

                    if($stmt->execute()){
                        if ($stmt->rowCount() > 0) {
                            $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            echo json_encode(array('members' => $members));
                        } else {
                            echo json_encode(array('status' => 'error', 'message' => 'No members registered to this thread'));
                    }
                }
                    else{
                        echo json_encode(array('Failed 3'));
                    }
                }
                else{
                    echo json_encode(array('status'=>'error', 'message'=>'You do not have the authority to perform this action'));
                }

                
            }
            else{
                echo json_encode(array('Failed 2'));
            }
        }
        else{
            echo json_encode(array('Failed 1'));
        }
    }

?>