<?php

include '../connection/config.php';

$method = $_SERVER['REQUEST_METHOD'];

    switch($method) {
        case 'GET':
        
            $stmt = $db->prepare("SELECT * FROM supplier");
            $stmt->execute();
            $result = $stmt->get_result();

            $list = $result->fetch_all();

            echo json_encode($list);

            // if(mysqli_num_rows($result) > 0) {
            //     while($list = $result->fetch_assoc()) {
            //          $response= $list;  
            //          echo json_encode($response);
            //     } 
            // } else {
            //     echo json_encode("No data");
            // }
            break;


            mysqli_close($db);


            

}

?>