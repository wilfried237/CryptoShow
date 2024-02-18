<?php
    require("./function/DBConnection.php");
    
    function register_member(){
        $conn = connection_to_database();
        $sql = "";
        $result = $conn->query($sql);
    }
    function login_member(){

    }
    function show_all_member(){
        echo "show all members path";
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