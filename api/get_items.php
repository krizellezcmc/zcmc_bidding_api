<?php

include '../connection/config.php';

$method = $_SERVER['REQUEST_METHOD'];

    switch($method) {
        case 'GET':
            
        
            $stmt = $db->prepare("SELECT item.itemDesc, item.quantity FROM bidding INNER JOIN item ON bidding.FK_itemId = item.PK_itemId where bidding.dateAdded = ?  GROUP BY bidding.FK_itemId ORDER BY item.PK_itemId ;");
            $stmt->bind_param('s', $_GET['dateSelected']);
            $stmt->execute();
            $result = $stmt->get_result();

            $list = $result->fetch_all();


            if($list !== []) {
                echo json_encode($list);
            } else {
                echo json_encode([]);
            }

           

            // if(mysqli_num_rows($result) > 0) {
            //     while($list = $result->fetch_assoc()) {
            //          $response= $list;  
            //          echo json_encode($response);
            //     } 
            // } else {
            //     echo json_encode("No data");
            // }
            break;


}

?>