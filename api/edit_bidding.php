<?php

include '../connection/config.php';

$method = $_SERVER['REQUEST_METHOD'];

    switch($method) {
        case 'POST':
            $details = json_decode(file_get_contents('php://input'));

            $itemId = $details->itemId;
            $item = $details->itemDesc; 
            $qty = $details->quantity;
            $supplierDetails = $details->suppliers;

                $stmt = $db->prepare("UPDATE item SET itemDesc = ?, quantity = ?, lastEdit = CURRENT_TIMESTAMP() WHERE PK_itemId = ?");
                $stmt->bind_param("sdi", $item, $qty, $itemId);

                if($stmt->execute()) {
                    foreach($supplierDetails as $key => $val){
                        $supplierId = $val->supplierId;
                        $unitCost = $val->unitCost;

                        $bidding = $db->prepare("UPDATE bidding SET FK_supplierId = ?, unitCost = ? WHERE FK_supplierId = ? AND FK_itemId = ?");
                        $bidding->bind_param("idii", $supplierId, $unitCost, $supplierId, $itemId);

                        if($bidding->execute()){
                            $data = ['status' => 1, 'message' => "Success edit"];
                        }else {
                            $data = ['status' => 0, 'message' => "Edit failed"];
                        }
                    }

                } else {
                    $data = ['status' => 0, 'message' => "Failed"];
                }
            
            echo json_encode($data);
            break;
}

?>