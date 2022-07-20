<?php

include '../connection/config.php';

$method = $_SERVER['REQUEST_METHOD'];

    switch($method) {
        case 'POST':
            $details = json_decode(file_get_contents('php://input'));

            $random1 = rand(1,1000);
            $random2 = rand(1,1000);

            $itemId = $random1.$random2;
            
            $item = $details->item;
            $qty = $details->quantity;

            $supplierDetails = $details->suppliers;
        
            $stmt = $db->prepare("INSERT INTO item(PK_itemId, itemDesc, quantity) VALUES(?, ?, ?)");
            $stmt->bind_param("isd", $itemId, $item, $qty);

            if($stmt->execute()) {

                foreach($supplierDetails as $key => $val){
                    $supplierId = $val->supplierId;
                    $unitCost = $val->unitCost;

                    $bidding = $db->prepare("INSERT INTO bidding(FK_itemId, FK_supplierId, unitCost) VALUES(?, ?, ?)");
                    $bidding->bind_param("iid", $itemId, $supplierId, $unitCost);

                    if($bidding->execute()){
                        $data = ['status' => 1, 'message' => "Success bidding entry"];
                    }else {
                        $data = ['status' => 0, 'message' => "Failed bidding entry"];
                    }

                }

            } else {
                $data = ['status' => 0, 'message' => "Failed"];
            }

            echo json_encode($data);
            break;
}

?>