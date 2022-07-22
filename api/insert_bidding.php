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

            $object = array_reduce($supplierDetails, function($a, $b){
                return $a->unitCost < $b->unitCost ? $a : $b;
            }, array_shift($supplierDetails));

            $wSupplierId = $object->supplierId;
            $wUnitCost = $object->unitCost;

            $winner = $db->prepare("INSERT INTO winners(wItemDesc, wQuantity, FK_supplierId, wCost) VALUES(?, ?, ?, ?)");
            $winner->bind_param("siid", $item, $qty, $wSupplierId, $wUnitCost);

            if($winner->execute()) {

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
            } else {
                 $data = ['status' => 0, 'message' => "Failed winner insert"];
            }

            echo json_encode($data);
            break;
}

?>