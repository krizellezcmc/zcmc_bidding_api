<?php

include '../connection/config.php';

$method = $_SERVER['REQUEST_METHOD'];

    switch($method) {
        case 'GET':
        
            $stmt = $db->prepare("SELECT supplier.supplierName FROM supplier INNER JOIN bidding ON supplier.PK_supplierId = bidding.FK_supplierId where bidding.dateAdded = ? GROUP BY supplier.supplierName ORDER BY PK_supplierId;");
            $stmt->bind_param('s', $_GET['dateSelected']);
            $stmt->execute();
            $result = $stmt->get_result();

            if(mysqli_num_rows($result) != 0)
            
                while ($data = $result->fetch_array()) {

                $response[] = $data['supplierName'];

                 // <--- available in $data
            } else {
               $response = ["No supplier added"];
            }
         
            // if(mysqli_num_rows($result) > 0) {
            //     while($list = $result->fetch_assoc()) {
            //          $response= $list;  
            //          echo json_encode($response);
            //     } 
            // } else {
                echo json_encode($response);
            // }
            break;
           
}

?>