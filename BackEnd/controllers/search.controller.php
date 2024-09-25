<?php
    require_once("./function/DBConnection.php");


    function get_thread_names(){

        header('Access-Control-Allow-Origin: http://localhost:8888');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');

        //sql statement to retreve thread names
        $sql = 'SELECT Thread_name FROM Thread;';

        //connection to database
        $conn = connection_to_Maria_DB();
        $stmt = $conn->prepare($sql);

        //created an empty array to store names
        $names = array();

        //if succesful then array is filled with thread names
        if ($stmt->execute()) {
            $names = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array('status' => 'success', 'names' => $names));
            return $names;
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Error fetching names'));
        }
    }

    //    This is the fxn to make basic(thread)searches in an array
    function searchInArray($array, $needle) {
        return in_array($needle, $array);
    }

    // Example usage:
    $array = array("get_thread_names");
    $needle = "orange";
    if (searchInArray($array, $needle)) {
        echo "Found!";
    } else {
        echo "Not Found!";
    }

?>